<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('login_id')->nullable()->unique()->after('role');
            $table->string('employee_id')->nullable()->after('login_id');
            $table->string('sss')->nullable()->after('employee_id');
            $table->string('tin')->nullable()->after('sss');
            $table->string('philhealth')->nullable()->after('tin');
            $table->string('pagibig')->nullable()->after('philhealth');
        });

        DB::statement('ALTER TABLE users MODIFY birthdate DATE NULL');
        DB::statement('ALTER TABLE users MODIFY position VARCHAR(255) NULL');
        DB::statement('ALTER TABLE users MODIFY department VARCHAR(255) NULL');
        DB::statement('ALTER TABLE users MODIFY email VARCHAR(255) NULL');
        DB::statement('ALTER TABLE users MODIFY password VARCHAR(255) NULL');
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'login_id',
                'employee_id',
                'sss',
                'tin',
                'philhealth',
                'pagibig',
            ]);
        });
    }
};