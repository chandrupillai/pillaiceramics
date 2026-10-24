<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Add to tile_products
        Schema::table('tile_products', function (Blueprint $table) {
            $table->foreignId('product_type_id')->nullable()->after('id')->constrained('product_types')->onDelete('set null');
            $table->string('status')->default('active')->after('tile_size_id');
            $table->string('flag')->nullable()->after('status');
            $table->softDeletes();
        });

        // Add to daily_sales
        Schema::table('daily_sales', function (Blueprint $table) {
            $table->foreignId('product_type_id')->nullable()->after('product_id')->constrained('product_types')->onDelete('set null');
            $table->foreignId('tile_size_id')->nullable()->after('product_type_id')->constrained('tile_sizes')->onDelete('set null');
            $table->string('status')->default('completed')->after('vehicle_info');
            $table->string('flag')->nullable()->after('status');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('tile_products', function (Blueprint $table) {
            $table->dropForeign(['product_type_id']);
            $table->dropColumn(['product_type_id', 'status', 'flag', 'deleted_at']);
        });

        Schema::table('daily_sales', function (Blueprint $table) {
            $table->dropForeign(['product_type_id']);
            $table->dropForeign(['tile_size_id']);
            $table->dropColumn(['product_type_id', 'tile_size_id', 'status', 'flag', 'deleted_at']);
        });
    }
};
