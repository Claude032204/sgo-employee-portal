<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'login_id')) {
                $table->string('login_id')->nullable()->unique()->after('role');
            }

            if (!Schema::hasColumn('users', 'employee_id')) {
                $table->string('employee_id')->nullable()->after('login_id');
            }

            if (!Schema::hasColumn('users', 'sss')) {
                $table->string('sss')->nullable()->after('employee_id');
            }

            if (!Schema::hasColumn('users', 'tin')) {
                $table->string('tin')->nullable()->after('sss');
            }

            if (!Schema::hasColumn('users', 'philhealth')) {
                $table->string('philhealth')->nullable()->after('tin');
            }

            if (!Schema::hasColumn('users', 'pagibig')) {
                $table->string('pagibig')->nullable()->after('philhealth');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [];

            foreach (['login_id', 'employee_id', 'sss', 'tin', 'philhealth', 'pagibig'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $columns[] = $column;
                }
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};