<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('daily_offers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image');
            $table->boolean('status')->default(1); // 1 = Active, 0 = Inactive
            $table->date('offer_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_offers');
    }
};