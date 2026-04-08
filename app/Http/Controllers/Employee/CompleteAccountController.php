<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CompleteAccountController extends Controller
{
    public function edit()
    {
        return view('employee.complete-account');
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = auth()->user();

        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->temp_password = null;
        $user->must_change_password = false;
        $user->email_verified_at = null;
        $user->save();

        $user->sendEmailVerificationNotification();

        return redirect()
            ->route('verification.notice')
            ->with('status', 'Account completed. Please verify your email.');
    }
}