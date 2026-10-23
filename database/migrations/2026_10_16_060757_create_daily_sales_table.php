<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('daily_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Sales person
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_type')->nullable();;
            $table->date('sale_date');
            $table->decimal('quantity', 10, 2);
            $table->string('bill_shop_name');
            $table->string('vehicle_info')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_sales');
    }
};
