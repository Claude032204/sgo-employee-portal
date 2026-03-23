<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Payslip;
use Illuminate\Support\Facades\Storage;

class PayslipController extends Controller
{
    public function index()
    {
        $payslips = Payslip::where('user_id', auth()->id())
            ->where('match_status', 'matched')
            ->latest()
            ->get();

        return view('employee.payslips.index', compact('payslips'));
    }

    public function show($id)
    {
        $payslip = Payslip::where('user_id', auth()->id())
            ->where('match_status', 'matched')
            ->where('id', $id)
            ->firstOrFail();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'view_payslip',
            'description' => auth()->user()->name . ' viewed payslip for ' . $payslip->pay_period,
        ]);

        return view('employee.payslips.show', compact('payslip'));
    }

    public function download($id)
    {
        $payslip = Payslip::where('user_id', auth()->id())
            ->where('match_status', 'matched')
            ->where('id', $id)
            ->firstOrFail();

        if (!$payslip->file_path || !Storage::disk('public')->exists($payslip->file_path)) {
            abort(404, 'Payslip file not found.');
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'download_payslip',
            'description' => auth()->user()->name . ' downloaded payslip for ' . $payslip->pay_period,
        ]);

        $extension = pathinfo($payslip->file_path, PATHINFO_EXTENSION);
        $safePayPeriod = str_replace([' ', '/'], '_', $payslip->pay_period);
        $fileName = 'Payslip_' . $safePayPeriod . '.' . $extension;

        return Storage::disk('public')->download($payslip->file_path, $fileName);
    }
}