<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use App\Models\User;

class GenerateEmployeePortalId
{
    public function handle(Verified $event): void
    {
        $user = $event->user;

        if ($user->role !== 'employee') {
            return;
        }

        if (!empty($user->login_id)) {
            return;
        }

        $datePart = optional($user->email_verified_at)->format('mdY') ?? now()->format('mdY');
        $prefix = 'SGO' . $datePart;

        $sequence = 1;

        do {
            $candidateId = $prefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);
            $exists = User::where('login_id', $candidateId)->exists();
            $sequence++;
        } while ($exists);

        $user->login_id = $candidateId;
        $user->save();
    }
}