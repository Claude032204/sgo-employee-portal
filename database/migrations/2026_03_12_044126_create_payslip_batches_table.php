<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payslip_batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_name');
            $table->string('zip_file_path')->nullable();
            $table->unsignedBigInteger('uploaded_by');
            $table->integer('total_files')->default(0);
            $table->integer('total_payslips')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payslip_batches');
    }
};