<?php

namespace Tests\Feature\Tenant;

use App\Models\Product;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected $tenant;
    protected $user;

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
        
        // Force URL to tenant domain
        URL::forceRootUrl('http://' . $this->tenant->domains->first()->domain);
    }

    public function test_tenant_can_view_products_list()
    {
        $response = $this->actingAs($this->user)
            ->get(route('tenant.products.index'));

        $response->assertStatus(200);
        $response->assertViewIs('tenant.products.index');
    }

    public function test_tenant_can_create_product()
    {
        $productData = [
            'name' => 'Vidro Temperado 8mm',
            'type' => 'glass',
            'price' => 150.00,
            'unit' => 'm2',
            'thickness' => 8,
            'color' => 'Incolor',
        ];

        $response = $this->actingAs($this->user)
            ->post(route('tenant.products.store'), $productData);

        $response->assertRedirect(route('tenant.products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Vidro Temperado 8mm',
            'tenant_id' => $this->tenant->id,
        ]);
    }

    public function test_tenant_cannot_see_products_from_other_tenant()
    {
        // Create another tenant
        $otherTenant = Tenant::create(['id' => 'other-tenant']);
        $otherTenant->domains()->create(['domain' => 'other.localhost']);

        // Create product for other tenant
        tenancy()->initialize($otherTenant);
        Product::create([
            'name' => 'Other Product',
            'type' => 'glass',
            'price' => 100,
            'unit' => 'm2',
            'tenant_id' => $otherTenant->id,
        ]);
        tenancy()->end();

        // Switch back to main tenant
        tenancy()->initialize($this->tenant);

        // Create product for main tenant
        Product::create([
            'name' => 'My Product',
            'type' => 'glass',
            'price' => 200,
            'unit' => 'm2',
            'tenant_id' => $this->tenant->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('tenant.products.index'));

        $response->assertSee('My Product');
        $response->assertDontSee('Other Product');
    }
}
