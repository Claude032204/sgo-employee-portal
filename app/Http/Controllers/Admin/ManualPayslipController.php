<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payslip;
use App\Models\User;
use Illuminate\Http\Request;

class ManualPayslipController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'month' => ['required', 'string', 'max:20'],
            'start_day' => ['required', 'integer', 'min:1', 'max:31'],
            'end_day' => ['required', 'integer', 'min:1', 'max:31'],
            'year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'payslip_file' => ['required', 'file', 'mimes:png,jpg,jpeg'],
        ]);

        $payPeriod = $this->buildPayPeriod(
            $request->month,
            (int) $request->start_day,
            (int) $request->end_day,
            (int) $request->year
        );

        $user = User::findOrFail($request->user_id);

        $filePath = $request->file('payslip_file')->store('manual_payslips', 'public');

        Payslip::create([
            'user_id' => $user->id,
            'employee_portal_id' => $user->login_id,
            'employee_name' => $user->name,
            'source_pdf' => null,
            'file_path' => $filePath,
            'detected_name' => $user->name,
            'match_status' => 'matched',
            'page_number' => 1,
            'segment_position' => 'manual',
            'pay_period' => $payPeriod,
            'basic_pay' => 0,
            'deductions' => 0,
            'net_pay' => 0,
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.payslips.upload')
            ->with('manual_success', 'Manual payslip uploaded successfully.');
    }

    private function buildPayPeriod(string $month, int $startDay, int $endDay, int $year): string
    {
        if ($startDay > $endDay) {
            abort(422, 'Start day cannot be greater than end day.');
        }

        if ($startDay === $endDay) {
            return "{$month} {$startDay}, {$year}";
        }

        return "{$month} {$startDay}-{$endDay}, {$year}";
    }
}