<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tile_products', function (Blueprint $table) {
            $table->foreignId('production_company_id')
                ->nullable()
                ->after('location_id') // or after('godown_id') depending on your schema
                ->constrained('production_companies')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tile_products', function (Blueprint $table) {
            $table->dropForeign(['production_company_id']);
            $table->dropColumn('production_company_id');
        });
    }
};
