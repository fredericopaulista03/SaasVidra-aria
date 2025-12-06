<?php

namespace Tests\Feature\Tenant;

use App\Models\Budget;
use App\Models\Client;
use App\Models\Product;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class BudgetTest extends TestCase
{
    use RefreshDatabase;

    protected $tenant;
    protected $user;
    protected $client;
    protected $productGlass;
    protected $productHardware;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Tenant
        $this->tenant = Tenant::create(['id' => 'test-tenant']);
        $this->tenant->domains()->create(['domain' => 'test.localhost']);

        // Initialize Tenancy
        tenancy()->initialize($this->tenant);

        // Create User
        $this->user = User::factory()->create([
            'tenant_id' => $this->tenant->id,
        ]);

        // Create Client
        $this->client = Client::create([
            'name' => 'John Doe',
            'tenant_id' => $this->tenant->id,
        ]);

        // Create Products
        $this->productGlass = Product::create([
            'name' => 'Glass 10mm',
            'type' => 'glass',
            'price' => 100.00, // per m2
            'unit' => 'm2',
            'tenant_id' => $this->tenant->id,
        ]);

        $this->productHardware = Product::create([
            'name' => 'Handle',
            'type' => 'hardware',
            'price' => 50.00, // per unit
            'unit' => 'un',
            'tenant_id' => $this->tenant->id,
        ]);
        
        // Force URL to tenant domain
        URL::forceRootUrl('http://' . $this->tenant->domains->first()->domain);
    }

    public function test_tenant_can_create_budget_draft()
    {
        $response = $this->actingAs($this->user)
            ->post(route('tenant.budgets.store'), [
                'client_id' => $this->client->id,
            ]);

        $budget = Budget::latest()->first();
        
        $this->assertNotNull($budget, 'Budget was not created');

        $response->assertRedirect(route('tenant.budgets.edit', $budget));
        $this->assertDatabaseHas('budgets', [
            'client_id' => $this->client->id,
            'status' => 'draft',
            'tenant_id' => $this->tenant->id,
        ]);
    }

    public function test_tenant_can_update_budget_with_items_and_calculations()
    {
        $budget = Budget::create([
            'client_id' => $this->client->id,
            'tenant_id' => $this->tenant->id,
        ]);

        $itemsData = [
            'items' => [
                [
                    'product_id' => $this->productGlass->id,
                    'quantity' => 2,
                    'width' => 1000, // 1m
                    'height' => 2000, // 2m
                    'unit_price' => 100.00,
                ],
                [
                    'product_id' => $this->productHardware->id,
                    'quantity' => 4,
                    'unit_price' => 50.00,
                ]
            ],
            'discount' => 20.00,
        ];

        // Expected Calculation:
        // Glass: 2 * (1m * 2m) * 100 = 400
        // Hardware: 4 * 50 = 200
        // Subtotal: 600
        // Total: 600 - 20 = 580

        $response = $this->actingAs($this->user)
            ->put(route('tenant.budgets.update', $budget), $itemsData);

        $response->assertRedirect(route('tenant.budgets.index'));
        
        $this->assertDatabaseHas('budgets', [
            'id' => $budget->id,
            'subtotal' => 600.00,
            'total' => 580.00,
        ]);

        $this->assertCount(2, $budget->items);
    }

    public function test_tenant_cannot_see_budgets_from_other_tenant()
    {
        // Create another tenant
        $otherTenant = Tenant::create(['id' => 'other-tenant']);
        $otherTenant->domains()->create(['domain' => 'other.localhost']);

        // Create budget for other tenant
        tenancy()->initialize($otherTenant);
        $otherClient = Client::create(['name' => 'Other Client', 'tenant_id' => $otherTenant->id]);
        Budget::create([
            'client_id' => $otherClient->id,
            'tenant_id' => $otherTenant->id,
            'total' => 999,
        ]);
        tenancy()->end();

        // Switch back to main tenant
        tenancy()->initialize($this->tenant);

        // Create budget for main tenant
        Budget::create([
            'client_id' => $this->client->id,
            'tenant_id' => $this->tenant->id,
            'total' => 123,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('tenant.budgets.index'));

        $response->assertSee('123');
        $response->assertDontSee('999');
    }
}
