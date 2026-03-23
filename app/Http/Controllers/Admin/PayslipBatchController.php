<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Payslip;
use App\Models\PayslipBatch;
use App\Models\User;
use Illuminate\Http\Request;
use ZipArchive;

class PayslipBatchController extends Controller
{
    public function index()
    {
        $batches = PayslipBatch::latest()->get();

        return view('admin.payslips.index', compact('batches'));
    }

    public function create()
    {
        return view('admin.payslips.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'zip_file' => ['required', 'file', 'mimes:zip'],
            'pay_period' => ['required', 'string', 'max:255'],
        ]);

        $zipPath = $request->file('zip_file')->store('payslip_zips', 'public');

        $batch = PayslipBatch::create([
            'batch_name' => 'Payslip Batch - ' . now()->format('Y-m-d H:i:s'),
            'zip_file_path' => $zipPath,
            'uploaded_by' => auth()->id(),
            'total_files' => 0,
            'total_payslips' => 0,
        ]);

        $this->logActivity(
            auth()->id(),
            'upload_batch',
            'Uploaded payslip ZIP batch: ' . $batch->batch_name
        );

        $zipFullPath = storage_path('app/public/' . $zipPath);
        $extractPath = storage_path('app/public/payslip_batches/batch_' . $batch->id . '/source');
        $imagePath = storage_path('app/public/payslip_batches/batch_' . $batch->id . '/images');
        $cropPath = storage_path('app/public/payslip_batches/batch_' . $batch->id . '/crops');

        if (!file_exists($extractPath)) {
            mkdir($extractPath, 0777, true);
        }

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0777, true);
        }

        if (!file_exists($cropPath)) {
            mkdir($cropPath, 0777, true);
        }

        $zip = new ZipArchive();

        if ($zip->open($zipFullPath) === true) {
            $zip->extractTo($extractPath);
            $zip->close();
        } else {
            return back()->withErrors([
                'zip_file' => 'Could not open ZIP file.',
            ]);
        }

        $pdfFiles = collect(scandir($extractPath))
            ->filter(fn($file) => str_ends_with(strtolower($file), '.pdf'))
            ->values();

        $batch->update([
            'total_files' => $pdfFiles->count(),
        ]);

        foreach ($pdfFiles as $pdfFile) {
            $fullPdfPath = $extractPath . DIRECTORY_SEPARATOR . $pdfFile;
            $baseName = pathinfo($pdfFile, PATHINFO_FILENAME);

            // Convert all pages of PDF to PNG files
            $outputPattern = $imagePath . DIRECTORY_SEPARATOR . $baseName . '_page_%03d.png';

            $gsCommand = 'gswin64c -dSAFER -dBATCH -dNOPAUSE -sDEVICE=png16m -r350 ' .
                '-sOutputFile="' . $outputPattern . '" "' . $fullPdfPath . '"';

            exec($gsCommand, $output, $resultCode);

            if ($resultCode !== 0) {
                $this->logActivity(
                    auth()->id(),
                    'pdf_render_failed',
                    'Failed to render PDF: ' . $pdfFile
                );
                continue;
            }

            $renderedPages = collect(scandir($imagePath))
                ->filter(function ($file) use ($baseName) {
                    return str_starts_with($file, $baseName . '_page_')
                        && str_ends_with(strtolower($file), '.png');
                })
                ->sort()
                ->values();

            foreach ($renderedPages as $index => $pageImageFile) {
                $pageImagePath = $imagePath . DIRECTORY_SEPARATOR . $pageImageFile;
                $pageNumber = $index + 1;

                $this->splitPageDynamically(
                    $pageImagePath,
                    $cropPath,
                    $batch->id,
                    $pdfFile,
                    $request->pay_period,
                    $pageNumber
                );
            }
        }

        $batch->update([
            'total_payslips' => Payslip::where('batch_id', $batch->id)->count(),
        ]);

        $this->logActivity(
            auth()->id(),
            'process_batch',
            'Processed batch ' . $batch->batch_name . ' with ' . $batch->total_payslips . ' cropped payslips.'
        );

        return redirect()
            ->route('admin.payslips.unmatched', $batch->id)
            ->with('success', 'ZIP uploaded successfully. Payslips were cropped and matched where possible.');
    }

    private function splitPageDynamically(
        string $imagePath,
        string $cropPath,
        int $batchId,
        string $sourcePdf,
        string $payPeriod,
        int $pageNumber
    ): void {
        $image = imagecreatefrompng($imagePath);

        if (!$image) {
            return;
        }

        $width = imagesx($image);
        $height = imagesy($image);

        // Ignore side margins
        $leftMargin = (int) round($width * 0.05);
        $rightMargin = (int) round($width * 0.95);

        $contentRows = [];

        for ($y = 0; $y < $height; $y++) {
            $darkPixels = 0;
            $sampleCount = 0;

            for ($x = $leftMargin; $x < $rightMargin; $x += 4) {
                $rgb = imagecolorat($image, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $brightness = ($r + $g + $b) / 3;

                if ($brightness < 245) {
                    $darkPixels++;
                }

                $sampleCount++;
            }

            $darkRatio = $sampleCount > 0 ? ($darkPixels / $sampleCount) : 0;
            $contentRows[$y] = $darkRatio > 0.015;
        }

        // Build raw bands
        $bands = [];
        $inBand = false;
        $startY = 0;

        for ($y = 0; $y < $height; $y++) {
            if ($contentRows[$y] && !$inBand) {
                $startY = $y;
                $inBand = true;
            }

            if ((!$contentRows[$y] || $y === $height - 1) && $inBand) {
                $endY = ($contentRows[$y] && $y === $height - 1) ? $y : $y - 1;
                $bands[] = [$startY, $endY];
                $inBand = false;
            }
        }

        // Merge tiny gaps
        $mergedBands = [];
        $minGap = 30;

        foreach ($bands as $band) {
            if (empty($mergedBands)) {
                $mergedBands[] = $band;
                continue;
            }

            $lastIndex = count($mergedBands) - 1;
            $lastBand = $mergedBands[$lastIndex];
            $gap = $band[0] - $lastBand[1];

            if ($gap <= $minGap) {
                $mergedBands[$lastIndex][1] = $band[1];
            } else {
                $mergedBands[] = $band;
            }
        }

        // Remove noise
        $validBands = [];
        $minBandHeight = 180;

        foreach ($mergedBands as $band) {
            $bandHeight = $band[1] - $band[0] + 1;

            if ($bandHeight >= $minBandHeight) {
                $validBands[] = $band;
            }
        }

        foreach ($validBands as $i => $band) {
            $topPadding = 8;
            $bottomPadding = 8;

            $cropY = max(0, $band[0] - $topPadding);
            $cropHeight = min(
                $height - $cropY,
                ($band[1] - $band[0] + 1) + $topPadding + $bottomPadding
            );

            $cropped = imagecrop($image, [
                'x' => 0,
                'y' => $cropY,
                'width' => $width,
                'height' => $cropHeight,
            ]);

            if (!$cropped) {
                continue;
            }

            $segmentNumber = $i + 1;
            $cropFileName = pathinfo($sourcePdf, PATHINFO_FILENAME)
                . '_page' . $pageNumber
                . '_segment' . $segmentNumber
                . '.png';

            $cropFullPath = $cropPath . DIRECTORY_SEPARATOR . $cropFileName;

            imagepng($cropped, $cropFullPath);
            imagedestroy($cropped);

            $relativeFilePath = 'payslip_batches/batch_' . $batchId . '/crops/' . $cropFileName;

            $ocrText = $this->extractTextFromImage($cropFullPath);
            [$matchedUser, $detectedName] = $this->matchEmployeeFromText($ocrText);

            Payslip::create([
                'batch_id' => $batchId,
                'user_id' => $matchedUser?->id,
                'employee_portal_id' => $matchedUser?->employee_portal_id,
                'employee_name' => $matchedUser?->name,
                'source_pdf' => $sourcePdf,
                'file_path' => $relativeFilePath,
                'detected_name' => $detectedName,
                'match_status' => $matchedUser ? 'matched' : 'unmatched',
                'page_number' => $pageNumber,
                'segment_position' => 'segment_' . $segmentNumber,
                'pay_period' => $payPeriod,
                'basic_pay' => 0,
                'deductions' => 0,
                'net_pay' => 0,
                'uploaded_by' => auth()->id(),
            ]);
        }

        imagedestroy($image);
    }

    private function extractTextFromImage(string $imagePath): string
    {
        $tempOutput = storage_path('app/temp_ocr_' . uniqid());

        $command = 'tesseract "' . $imagePath . '" "' . $tempOutput . '" --psm 6 2>NUL';
        exec($command, $output, $resultCode);

        $textFile = $tempOutput . '.txt';

        if ($resultCode !== 0 || !file_exists($textFile)) {
            return '';
        }

        $text = file_get_contents($textFile) ?: '';

        @unlink($textFile);

        return $text;
    }

    private function matchEmployeeFromText(string $ocrText): array
    {
        if (trim($ocrText) === '') {
            return [null, null];
        }

        $normalizedText = $this->normalizeText($ocrText);
        $employees = User::where('role', 'employee')->get();

        $bestMatch = null;
        $bestScore = 0;

        foreach ($employees as $employee) {
            $name = $this->normalizeName($employee->name);

            // Exact full-name match
            if (str_contains($normalizedText, $name)) {
                return [$employee, $employee->name];
            }

            // Reversed format match: LASTNAME, FIRSTNAME MIDDLENAME
            $reversed = $this->normalizeReversedName($employee->name);
            if (str_contains($normalizedText, $reversed)) {
                return [$employee, $employee->name];
            }

            // Partial match: first + last
            $parts = explode(' ', $name);
            if (count($parts) >= 2) {
                $first = $parts[0];
                $last = end($parts);

                if (str_contains($normalizedText, $first) && str_contains($normalizedText, $last)) {
                    return [$employee, $employee->name];
                }
            }

            // Fuzzy similarity
            similar_text($normalizedText, $name, $percent);

            if ($percent > $bestScore) {
                $bestScore = $percent;
                $bestMatch = $employee;
            }
        }

        if ($bestScore > 65 && $bestMatch) {
            return [$bestMatch, $bestMatch->name];
        }

        return [null, null];
    }

    private function normalizeText(string $text): string
    {
        $text = strtoupper($text);
        $text = str_replace(['-', '.', ','], ' ', $text);
        $text = preg_replace('/[^A-Z0-9\s]/', ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
    }

    private function normalizeName(string $name): string
    {
        $name = strtoupper($name);
        $name = str_replace(['-', '.', ','], ' ', $name);
        $name = preg_replace('/[^A-Z0-9\s]/', ' ', $name);
        $name = preg_replace('/\s+/', ' ', $name);

        return trim($name);
    }

    private function normalizeReversedName(string $name): string
    {
        $name = trim($name);

        if (!str_contains($name, ' ')) {
            return $this->normalizeName($name);
        }

        $parts = preg_split('/\s+/', $name);
        $lastName = array_pop($parts);
        $firstNames = implode(' ', $parts);

        $reversed = $lastName . ', ' . $firstNames;
        $reversed = strtoupper($reversed);
        $reversed = str_replace(['-', '.', ','], ' ', $reversed);
        $reversed = preg_replace('/[^A-Z0-9\s]/', ' ', $reversed);
        $reversed = preg_replace('/\s+/', ' ', $reversed);

        return trim($reversed);
    }

    public function unmatched($batchId)
    {
        $batch = PayslipBatch::findOrFail($batchId);

        $payslips = Payslip::where('batch_id', $batch->id)
            ->where('match_status', 'unmatched')
            ->orderBy('page_number')
            ->orderBy('id')
            ->get();

        $employees = User::where('role', 'employee')
            ->orderBy('name')
            ->get();

        return view('admin.payslips.unmatched', compact('batch', 'payslips', 'employees'));
    }

    public function assign(Request $request, $payslipId)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $payslip = Payslip::findOrFail($payslipId);
        $user = User::findOrFail($request->user_id);

        $payslip->update([
            'user_id' => $user->id,
            'employee_portal_id' => $user->employee_portal_id,
            'employee_name' => $user->name,
            'detected_name' => $user->name,
            'match_status' => 'matched',
        ]);

        $this->logActivity(
            auth()->id(),
            'assign_payslip',
            'Assigned payslip ID ' . $payslip->id . ' to employee ' . $user->name
        );

        return back()->with('success', 'Payslip assigned successfully.');
    }

    private function logActivity(?int $userId, string $action, string $description): void
    {
        ActivityLog::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
        ]);
    }
}