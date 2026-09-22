<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 15)->unique()->nullable()->after('email');
            
            // Roles: super_admin, admin, staff, dealer, customer
            $table->enum('role', [
                'super_admin', 
                'admin', 
                'staff', 
                'dealer', 
                'customer'
            ])->default('customer')->after('password');

            $table->boolean('is_active')->default(true)->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'role', 'is_active']);
        });
    }
};