<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tile_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('sku')->unique();
            $table->string('slug')->unique();
            
            // Relationships
            $table->foreignId('tile_category_id')->constrained('tile_categories')->onDelete('cascade');
            $table->foreignId('tile_type_id')->constrained('tile_types')->onDelete('cascade');
            $table->foreignId('tile_size_id')->constrained('tile_sizes')->onDelete('cascade');
            $table->foreignId('location_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->foreignId('godown_id')->nullable()->constrained('godowns')->onDelete('set null');

            // Inventory & Pricing
            $table->decimal('price', 10, 2)->default(0.00);
            $table->integer('stock_quantity')->default(0);
            $table->string('box_coverage_sqft')->nullable(); // Sq.ft per box
            $table->integer('pieces_per_box')->nullable();
            
            // Details & Images
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tile_products');
    }
};