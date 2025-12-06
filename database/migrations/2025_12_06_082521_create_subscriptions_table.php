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
        Schema::create('tenant_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained()->onDelete('restrict');
            $table->enum('status', ['trial', 'active', 'canceled', 'expired', 'suspended'])->default('trial');
            $table->datetime('starts_at');
            $table->datetime('ends_at')->nullable();
            $table->datetime('trial_ends_at')->nullable();
            $table->datetime('canceled_at')->nullable();
            $table->string('asaas_subscription_id')->nullable();
            $table->string('stripe_subscription_id')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_subscriptions');
    }
};
