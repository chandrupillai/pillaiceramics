<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dealer_enquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dealer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tile_product_id')->constrained('tile_products')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete(); // Staff who updated status
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dealer_enquiries');
    }
};