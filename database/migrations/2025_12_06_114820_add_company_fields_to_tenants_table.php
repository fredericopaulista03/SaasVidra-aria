<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('website')->nullable()->after('id');
            $table->string('owner_phone')->nullable()->after('website');
            $table->string('document')->nullable()->after('owner_phone'); // CPF or CNPJ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['website', 'owner_phone', 'document']);
        });
    }
};
