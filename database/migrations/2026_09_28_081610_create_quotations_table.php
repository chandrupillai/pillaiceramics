<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_no')->unique(); // e.g., QT-2026-0001
            $table->foreignId('dealer_id')->nullable()->constrained('users')->nullOnDelete(); // Optional: linked dealer
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->text('customer_address')->nullable();
            
            $table->decimal('subtotal', 12, 2)->default(0.00);
            $table->decimal('tax_amount', 12, 2)->default(0.00); // GST or Sales Tax
            $table->decimal('discount', 12, 2)->default(0.00);
            $table->decimal('grand_total', 12, 2)->default(0.00);
            
            $table->enum('status', ['draft', 'sent', 'accepted', 'rejected', 'expired'])->default('draft');
            $table->date('valid_until')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained('quotations')->onDelete('cascade');
            $table->foreignId('tile_product_id')->nullable()->constrained('tile_products')->nullOnDelete();
            $table->string('product_name'); // Kept in case product gets deleted later
            $table->integer('boxes')->default(1);
            $table->decimal('sqft_per_box', 8, 2)->default(0.00);
            $table->decimal('total_sqft', 10, 2)->default(0.00);
            $table->decimal('unit_price', 10, 2)->default(0.00); // Price per sqft or per box
            $table->decimal('total_price', 12, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_items');
        Schema::dropIfExists('quotations');
    }
};