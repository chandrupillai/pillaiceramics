<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tile_products', function (Blueprint $table) {
            $table->unsignedBigInteger('tile_category_id')->nullable()->change();
            $table->unsignedBigInteger('tile_type_id')->nullable()->change();
            $table->unsignedBigInteger('tile_size_id')->nullable()->change();
            $table->string('slug')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('tile_products', function (Blueprint $table) {
            $table->unsignedBigInteger('tile_category_id')->nullable(false)->change();
            $table->unsignedBigInteger('tile_type_id')->nullable(false)->change();
            $table->unsignedBigInteger('tile_size_id')->nullable(false)->change();
            $table->string('slug')->nullable(false)->change();

        });
    }
};
