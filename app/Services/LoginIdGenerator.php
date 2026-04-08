<?php

namespace App\Services;

use App\Models\LoginIdSequence;
use Illuminate\Support\Facades\DB;

class LoginIdGenerator
{
    public static function generate(): string
    {
        $datePart = now()->format('mdy');

        return DB::transaction(function () use ($datePart) {
            $sequence = LoginIdSequence::lockForUpdate()->first();

            if (!$sequence) {
                $sequence = LoginIdSequence::create([
                    'last_number' => 0,
                ]);
            }

            $sequence->last_number += 1;
            $sequence->save();

            return 'SGO' . $datePart . '-' . str_pad($sequence->last_number, 3, '0', STR_PAD_LEFT);
        });
    }
}