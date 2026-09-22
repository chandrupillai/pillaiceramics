<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Optional assignments
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->foreignId('godown_id')->nullable()->constrained('godowns')->nullOnDelete();
            
            // Business / Dealer profile details
            $table->string('company_name')->nullable();
            $table->string('gst_number')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode', 10)->nullable();
            $table->string('avatar')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};