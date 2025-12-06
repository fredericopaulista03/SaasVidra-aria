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
        // 1. Clients
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('document')->nullable(); // CPF/CNPJ
            $table->string('zip_code')->nullable();
            $table->string('address')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 2. Products (Vidros, Ferragens, Serviços)
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->string('name');
            $table->string('type'); // glass, hardware, service, accessory
            $table->decimal('price', 10, 2);
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->string('unit'); // m2, unit, kg, linear_meter
            $table->integer('stock')->default(0);
            $table->decimal('thickness', 8, 2)->nullable(); // mm
            $table->string('color')->nullable();
            // $table->json('attributes')->nullable(); // Removed in favor of dedicated columns
            $table->timestamps();
        });

        // 3. Measures (Medidas)
        Schema::create('measures', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('name'); // "Janela Sala", "Box Banheiro"
            $table->decimal('width', 8, 2);
            $table->decimal('height', 8, 2);
            $table->decimal('area', 8, 2)->nullable(); // Calculated m2
            $table->string('glass_type')->nullable(); // Temperado, Laminado
            $table->string('glass_color')->nullable();
            $table->integer('glass_thickness')->nullable(); // 8mm, 10mm
            $table->string('installation_type')->nullable(); // Alvenaria, Drywall
            $table->text('description')->nullable();
            $table->string('status')->default('draft'); // draft, approved, rejected
            $table->timestamps();
        });

        // 4. Budgets (Orçamentos)
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->decimal('total', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->string('status')->default('draft'); // draft, sent, approved, rejected
            $table->date('valid_until')->nullable();
            $table->text('notes')->nullable();
            $table->text('payment_terms')->nullable();
            $table->timestamps();
        });

        // 5. Budget Items
        Schema::create('budget_items', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreignId('budget_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('measure_id')->nullable()->constrained()->onDelete('set null');
            $table->string('description');
            $table->decimal('quantity', 8, 2);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->timestamps();
        });

        // 6. Orders (Ordens de Serviço / Pedidos)
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreignId('budget_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pending'); // pending, in_production, ready, installed, completed
            $table->date('scheduled_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 7. Installations
        Schema::create('installations', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('status')->default('scheduled'); // scheduled, in_progress, completed, canceled
            $table->text('technician_notes')->nullable();
            $table->json('photos')->nullable(); // Before/After photos
            $table->timestamps();
        });

        // 8. Financial Transactions
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('type'); // income, expense
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->date('paid_at')->nullable();
            $table->string('payment_method')->nullable(); // pix, credit_card, cash, boleto
            $table->string('description');
            $table->timestamps();
        });

        // 9. Kanban Columns
        Schema::create('kanban_columns', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->string('name');
            $table->string('slug'); // Removed unique constraint as it should be unique per tenant, not globally
            $table->integer('order_index')->default(0);
            $table->string('color')->nullable();
            $table->timestamps();
        });

        // 10. Kanban Cards
        Schema::create('kanban_cards', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreignId('kanban_column_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('budget_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kanban_cards');
        Schema::dropIfExists('kanban_columns');
        Schema::dropIfExists('financial_transactions');
        Schema::dropIfExists('installations');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('budget_items');
        Schema::dropIfExists('budgets');
        Schema::dropIfExists('measures');
        Schema::dropIfExists('products');
        Schema::dropIfExists('clients');
    }
};
