<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayslipBatch extends Model
{
    protected $fillable = [
        'batch_name',
        'zip_file_path',
        'uploaded_by',
        'total_files',
        'total_payslips',
    ];

    public function payslips()
    {
        return $this->hasMany(Payslip::class, 'batch_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}