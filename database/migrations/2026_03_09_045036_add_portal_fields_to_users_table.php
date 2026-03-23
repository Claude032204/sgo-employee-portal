<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('employee')->after('password');
            $table->string('employee_portal_id')->nullable()->unique()->after('role');
            $table->date('birthdate')->nullable()->after('employee_portal_id');
            $table->string('position')->nullable()->after('birthdate');
            $table->string('department')->nullable()->after('position');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'employee_portal_id',
                'birthdate',
                'position',
                'department',
            ]);
        });
    }
};