<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\LoginIdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'employee');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('login_id', 'like', "%{$search}%")
                    ->orWhere('employee_id', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $employees = $query
            ->orderByRaw("CAST(SUBSTRING_INDEX(login_id, '-', -1) AS UNSIGNED) ASC")
            ->paginate(10);

        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
        ]);

        $lastName = strtoupper(trim($request->last_name));
        $firstName = trim($request->first_name);
        $middleName = $request->middle_name ? strtoupper(trim($request->middle_name)) : null;

        $fullName = trim(
            $lastName . ', ' . $firstName . ($middleName ? ' ' . $middleName : '')
        );

        $loginId = LoginIdGenerator::generate();

        $sequence = substr($loginId, -3);
        $temporaryPasswordPlain = $lastName . $sequence;

        User::create([
            'name' => $fullName,
            'last_name' => $lastName,
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'email' => null,
            'password' => Hash::make($temporaryPasswordPlain),
            'temp_password' => $temporaryPasswordPlain,
            'role' => 'employee',
            'login_id' => $loginId,
            'employee_id' => null,
            'sss' => null,
            'tin' => null,
            'philhealth' => null,
            'pagibig' => null,
            'birthdate' => null,
            'position' => null,
            'department' => null,
            'email_verified_at' => null,
            'must_change_password' => true,
        ]);

        return redirect()
            ->route('admin.employees.index')
            ->with(
                'success',
                'Employee added successfully. Login ID: ' . $loginId . ' | Temporary Password: ' . $temporaryPasswordPlain
            );
    }

    public function destroy($id)
    {
        $employee = User::where('role', 'employee')->findOrFail($id);
        $employee->delete();

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Employee removed successfully.');
    }
}