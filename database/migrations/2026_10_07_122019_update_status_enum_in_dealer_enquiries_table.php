<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE dealer_enquiries MODIFY COLUMN status ENUM('pending', 'processing', 'approved', 'rejected', 'completed', 'closed') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE dealer_enquiries MODIFY COLUMN status ENUM('pending', 'contacted', 'closed') DEFAULT 'pending'");
    }
};