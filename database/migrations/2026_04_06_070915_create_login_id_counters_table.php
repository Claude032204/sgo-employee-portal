<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('login_id_counters', function (Blueprint $table) {
            $table->id();
            $table->string('date_key')->unique(); // example: 040626
            $table->unsignedInteger('last_number')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_id_counters');
    }
};