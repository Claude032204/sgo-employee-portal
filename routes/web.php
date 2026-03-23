<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\PayslipController;
use App\Http\Controllers\Admin\PayslipBatchController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\EmployeeManagementController;
use App\Http\Controllers\Employee\EmployeeDashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('employee.dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'employee'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])
        ->name('employee.dashboard');

    Route::get('/employee/payslips', [PayslipController::class, 'index'])
        ->name('employee.payslips');

    Route::get('/employee/payslips/{id}', [PayslipController::class, 'show'])
        ->name('employee.payslips.show');

    Route::get('/employee/payslips/{id}/download', [PayslipController::class, 'download'])
        ->name('employee.payslips.download');
});

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/payslips', [PayslipBatchController::class, 'index'])
        ->name('admin.payslips.index');

    Route::get('/admin/payslips/upload', [PayslipBatchController::class, 'create'])
        ->name('admin.payslips.upload');

    Route::post('/admin/payslips/upload', [PayslipBatchController::class, 'store'])
        ->name('admin.payslips.store');

    Route::get('/admin/payslips/{batch}/unmatched', [PayslipBatchController::class, 'unmatched'])
        ->name('admin.payslips.unmatched');

    Route::post('/admin/payslips/{payslip}/assign', [PayslipBatchController::class, 'assign'])
        ->name('admin.payslips.assign');

    Route::get('/admin/employees', [EmployeeManagementController::class, 'index'])
        ->name('admin.employees.index');
});

require __DIR__ . '/auth.php';