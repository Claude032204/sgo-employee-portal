<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('must_change_password')->default(true)->after('password');
        });

        DB::statement('ALTER TABLE users MODIFY email VARCHAR(255) NULL');
        DB::statement('ALTER TABLE users MODIFY password VARCHAR(255) NULL');
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('must_change_password');
        });

        DB::statement('ALTER TABLE users MODIFY email VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE users MODIFY password VARCHAR(255) NOT NULL');
    }
};