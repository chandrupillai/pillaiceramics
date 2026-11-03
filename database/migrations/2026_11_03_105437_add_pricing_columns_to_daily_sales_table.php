<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('daily_sales', function (Blueprint $table) {
            $table->decimal('unit_price', 10, 2)->default(0)->after('quantity');
            $table->decimal('gst_amount', 10, 2)->nullable()->after('unit_price');
            $table->decimal('total_amount', 10, 2)->default(0)->after('gst_amount');
        });
    }

    public function down()
    {
        Schema::table('daily_sales', function (Blueprint $table) {
            $table->dropColumn(['unit_price', 'gst_amount', 'total_amount']);
        });
    }
};
