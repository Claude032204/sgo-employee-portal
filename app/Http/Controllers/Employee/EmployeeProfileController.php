<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        $hasIncompleteProfile = $this->hasIncompleteProfile($user);

        return view('employee.profile.edit', compact('user', 'hasIncompleteProfile'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'employee_id' => ['nullable', 'string', 'max:255'],
            'sss' => ['nullable', 'string', 'max:255'],
            'tin' => ['nullable', 'string', 'max:255'],
            'philhealth' => ['nullable', 'string', 'max:255'],
            'pagibig' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
        ]);

        $user->update([
            'employee_id' => $request->employee_id,
            'sss' => $request->sss,
            'tin' => $request->tin,
            'philhealth' => $request->philhealth,
            'pagibig' => $request->pagibig,
            'position' => $request->position,
            'department' => $request->department,
        ]);

        return redirect()
            ->route('employee.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }

    private function hasIncompleteProfile($user): bool
    {
        return empty($user->employee_id)
            || empty($user->sss)
            || empty($user->tin)
            || empty($user->philhealth)
            || empty($user->pagibig)
            || empty($user->position)
            || empty($user->department);
    }
}