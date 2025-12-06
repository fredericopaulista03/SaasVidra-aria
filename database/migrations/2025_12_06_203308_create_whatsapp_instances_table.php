<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_instances', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->unique();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->string('instance_name'); // Nome sanitizado da empresa
            $table->enum('instance_status', ['pending', 'qr_code', 'connected', 'disconnected', 'error'])->default('pending');
            $table->text('qr_code')->nullable();
            $table->timestamp('qr_code_expires_at')->nullable();
            $table->string('phone_number')->nullable();
            $table->timestamp('connected_at')->nullable();
            $table->timestamp('last_sync_at')->nullable();
            $table->string('evolution_instance_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_instances');
    }
};
