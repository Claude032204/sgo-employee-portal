<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payslips', function (Blueprint $table) {
            $table->unsignedBigInteger('batch_id')->nullable()->after('id');
            $table->string('source_pdf')->nullable()->after('employee_name');
            $table->string('file_path')->nullable()->after('source_pdf');
            $table->string('detected_name')->nullable()->after('file_path');
            $table->string('match_status')->default('unmatched')->after('detected_name');
            $table->integer('page_number')->nullable()->after('match_status');
            $table->string('segment_position')->nullable()->after('page_number'); // top, middle, bottom
        });
    }

    public function down(): void
    {
        Schema::table('payslips', function (Blueprint $table) {
            $table->dropColumn([
                'batch_id',
                'source_pdf',
                'file_path',
                'detected_name',
                'match_status',
                'page_number',
                'segment_position',
            ]);
        });
    }
};