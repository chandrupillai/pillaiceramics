<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('godowns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->string('name'); // e.g., Trichy Central Warehouse, Karaikal Stockyard
            $table->string('code')->unique()->nullable(); // e.g., TRZ-GD-01
            $table->text('address')->nullable();
            $table->string('incharge_person')->nullable();
            $table->string('contact_number')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('godowns');
    }
};