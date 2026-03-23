<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Payslip;
use App\Models\PayslipBatch;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = User::where('role', 'employee')->count();

        $totalPayslips = Payslip::count();

        $unmatchedPayslips = Payslip::where('match_status', 'unmatched')->count();

        $lastBatch = PayslipBatch::latest()->first();

        $recentUploads = PayslipBatch::latest()->take(5)->get();

        $pendingVerification = User::where('role', 'employee')
            ->whereNull('email_verified_at')
            ->count();

        $lastRegisteredEmployee = User::where('role', 'employee')
            ->latest()
            ->first();

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        $systemStatus = [
            'ocr' => $this->isTesseractAvailable() ? 'Active' : 'Not Ready',
            'pdf_processor' => 'Active',
            'last_batch_processed' => $lastBatch?->created_at?->diffForHumans() ?? 'No batch yet',
        ];

        return view('admin.dashboard', compact(
            'totalEmployees',
            'totalPayslips',
            'unmatchedPayslips',
            'lastBatch',
            'recentUploads',
            'pendingVerification',
            'lastRegisteredEmployee',
            'recentActivities',
            'systemStatus'
        ));
    }

    private function isTesseractAvailable(): bool
    {
        exec('where tesseract', $output, $resultCode);
        return $resultCode === 0 && !empty($output);
    }
}