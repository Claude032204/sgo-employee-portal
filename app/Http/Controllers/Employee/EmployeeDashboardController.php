<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Payslip;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalPayslips = Payslip::where('user_id', $user->id)
            ->where('match_status', 'matched')
            ->count();

        $latestPayslip = Payslip::where('user_id', $user->id)
            ->where('match_status', 'matched')
            ->latest()
            ->first();

        $recentPayslips = Payslip::where('user_id', $user->id)
            ->where('match_status', 'matched')
            ->latest()
            ->take(5)
            ->get();

        $accountStatus = [
            'email_verified' => !is_null($user->email_verified_at),
            'portal_access' => 'Active',
            'payslip_access' => $totalPayslips > 0 ? 'Ready' : 'No payslips yet',
        ];

        return view('employee.dashboard', compact(
            'user',
            'totalPayslips',
            'latestPayslip',
            'recentPayslips',
            'accountStatus'
        ));
    }
}