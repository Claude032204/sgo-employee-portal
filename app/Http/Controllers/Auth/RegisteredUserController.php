<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\LoginIdGenerator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $lastName = strtoupper(trim($request->last_name));
        $firstName = trim($request->first_name);
        $middleName = $request->middle_name ? strtoupper(trim($request->middle_name)) : null;

        $fullName = trim(
            $lastName . ', ' . $firstName . ($middleName ? ' ' . $middleName : '')
        );

        $user = User::create([
            'name' => $fullName,
            'last_name' => $lastName,
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee',
            'login_id' => LoginIdGenerator::generate(),
            'employee_id' => null,
            'sss' => null,
            'tin' => null,
            'philhealth' => null,
            'pagibig' => null,
            'birthdate' => null,
            'position' => null,
            'department' => null,
            'must_change_password' => false,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('verification.notice'));
    }
}