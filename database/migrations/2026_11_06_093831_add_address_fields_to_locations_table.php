<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            // Add state and other address columns if they don't exist yet
            if (!Schema::hasColumn('locations', 'state')) {
                $table->string('state')->nullable()->after('city');
            }
            if (!Schema::hasColumn('locations', 'postal_code')) {
                $table->string('postal_code', 20)->nullable()->after('state');
            }
        });
    }

    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn(['state', 'postal_code']);
        });
    }
};