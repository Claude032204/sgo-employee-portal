<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    protected $fillable = [
        'batch_id',
        'user_id',
        'employee_portal_id',
        'employee_name',
        'source_pdf',
        'file_path',
        'detected_name',
        'match_status',
        'page_number',
        'segment_position',
        'pay_period',
        'basic_pay',
        'deductions',
        'net_pay',
        'uploaded_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function batch()
    {
        return $this->belongsTo(PayslipBatch::class, 'batch_id');
    }
}