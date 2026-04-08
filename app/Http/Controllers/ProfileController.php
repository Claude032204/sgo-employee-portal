<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        if ($request->user()->role !== 'employee') {
            return redirect()->route('admin.dashboard');
        }

        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        if ($request->user()->role !== 'employee') {
            return redirect()->route('admin.dashboard');
        }

        $user = $request->user();

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

        return back()->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
