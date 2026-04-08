<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EmployeeSetupController extends Controller
{
    public function create()
    {
        return view('auth.employee-setup');
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_portal_id' => ['required', 'string'],
            'birthdate' => ['required', 'date'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::where('employee_portal_id', $request->employee_portal_id)
            ->where('birthdate', $request->birthdate)
            ->where('role', 'employee')
            ->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'employee_portal_id' => 'The Employee Portal ID and Birthdate do not match our records.',
                ])
                ->withInput();
        }

        if (!empty($user->password)) {
            return back()
                ->withErrors([
                    'employee_portal_id' => 'This employee account has already been activated.',
                ])
                ->withInput();
        }

        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->email_verified_at = now();
        $user->save();

        return redirect()
            ->route('login')
            ->with('status', 'Account setup completed. You may now log in.');
    }
}