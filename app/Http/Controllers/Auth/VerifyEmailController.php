<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectUser($request);
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $this->redirectUser($request);
    }

    protected function redirectUser(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('employee.dashboard');
    }
}