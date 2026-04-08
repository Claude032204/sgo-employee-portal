<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\PayslipController;
use App\Http\Controllers\Admin\PayslipBatchController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\EmployeeManagementController;
use App\Http\Controllers\Employee\EmployeeDashboardController;
use App\Http\Controllers\Admin\ManualPayslipController;
use App\Http\Controllers\Auth\EmployeeSetupController;
use App\Http\Controllers\Employee\CompleteAccountController;
use App\Http\Controllers\Employee\EmployeeProfileController;
use Illuminate\Support\Facades\Mail;

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

Route::middleware(['auth', 'employee'])->group(function () {
    Route::get('/employee/complete-account', [CompleteAccountController::class, 'edit'])
        ->name('employee.complete-account');

    Route::post('/employee/complete-account', [CompleteAccountController::class, 'update'])
        ->name('employee.complete-account.update');
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

    Route::get('/employee/profile', [EmployeeProfileController::class, 'edit'])
        ->name('employee.profile.edit');

    Route::patch('/employee/profile', [EmployeeProfileController::class, 'update'])
        ->name('employee.profile.update');
});

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/payslips', [PayslipBatchController::class, 'index'])
        ->name('admin.payslips.index');

    Route::get('/admin/payslips/upload', [PayslipBatchController::class, 'create'])
        ->name('admin.payslips.upload');

    Route::get('/admin/employees', [EmployeeManagementController::class, 'index'])
        ->name('admin.employees.index');

    Route::get('/admin/employees/create', [EmployeeManagementController::class, 'create'])
        ->name('admin.employees.create');

    Route::post('/admin/employees', [EmployeeManagementController::class, 'store'])
        ->name('admin.employees.store');

    Route::delete('/admin/employees/{id}', [EmployeeManagementController::class, 'destroy'])
        ->name('admin.employees.destroy');

    Route::post('/admin/payslips/upload', [PayslipBatchController::class, 'store'])
        ->name('admin.payslips.store');

    Route::post('/admin/manual-payslips', [ManualPayslipController::class, 'store'])
        ->name('admin.manual-payslips.store');

    Route::get('/admin/payslips/{batch}/unmatched', [PayslipBatchController::class, 'unmatched'])
        ->name('admin.payslips.unmatched');

    Route::post('/admin/payslips/{payslip}/assign', [PayslipBatchController::class, 'assign'])
        ->name('admin.payslips.assign');

    Route::delete('/admin/payslips/{batch}', [PayslipBatchController::class, 'destroy'])
        ->name('admin.payslips.destroy');

    Route::get('/admin/employees', [EmployeeManagementController::class, 'index'])
        ->name('admin.employees.index');

    Route::get('employee/setup', [EmployeeSetupController::class, 'create'])
        ->name('employee.setup');

    Route::post('employee/setup', [EmployeeSetupController::class, 'store'])
        ->name('employee.setup.store');
});

Route::get('/test-mail', function () {
    Mail::raw('This is a test email from SGO Portal.', function ($message) {
        $message->to('johnmarc145@gmail.com')
            ->subject('SGO Portal Test Email');
    });

    return 'Test email sent.';
});

require __DIR__ . '/auth.php';