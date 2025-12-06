<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Alter the enum to include quarterly and semiannual
        DB::statement("ALTER TABLE plans MODIFY COLUMN billing_cycle ENUM('monthly', 'quarterly', 'semiannual', 'yearly') DEFAULT 'monthly'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE plans MODIFY COLUMN billing_cycle ENUM('monthly', 'yearly') DEFAULT 'monthly'");
    }
};
