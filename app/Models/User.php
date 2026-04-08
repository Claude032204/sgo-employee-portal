<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'last_name',
        'first_name',
        'middle_name',
        'email',
        'password',
        'temp_password',
        'role',
        'login_id',
        'employee_id',
        'sss',
        'tin',
        'philhealth',
        'pagibig',
        'birthdate',
        'position',
        'department',
        'must_change_password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birthdate' => 'date',
            'password' => 'hashed',
            'must_change_password' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    public function uploadedPayslipBatches()
    {
        return $this->hasMany(PayslipBatch::class, 'uploaded_by');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail());
    }

}