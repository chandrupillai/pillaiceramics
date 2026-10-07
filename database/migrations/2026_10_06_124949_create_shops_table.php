<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('city');
            $table->text('address');
            $table->string('pincode')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('timing')->default('Mon - Sat: 09:00 AM - 08:30 PM');
            $table->text('google_maps_link')->nullable();
            $table->string('image')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable(); // Rich Text CMS Content
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
