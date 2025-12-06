<?php

namespace Tests\Feature\Tenant;

use App\Models\Client;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientTest extends TestCase
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
        
        // Assign Role (assuming Spatie permissions are set up)
        // $this->user->assignRole('owner'); 
        
        // Force URL to tenant domain for route() helper
        \Illuminate\Support\Facades\URL::forceRootUrl('http://' . $this->tenant->domains->first()->domain);
    }

    public function test_tenant_can_view_clients_list()
    {
        $response = $this->actingAs($this->user)
            ->get(route('tenant.clients.index'));

        $response->assertStatus(200);
        $response->assertViewIs('tenant.clients.index');
    }

    public function test_tenant_can_create_client()
    {
        $clientData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'city' => 'New York',
            'state' => 'NY',
        ];

        $response = $this->actingAs($this->user)
            ->post(route('tenant.clients.store'), $clientData);

        $response->assertRedirect(route('tenant.clients.index'));
        $this->assertDatabaseHas('clients', [
            'name' => 'John Doe',
            'tenant_id' => $this->tenant->id,
        ]);
    }

    public function test_tenant_cannot_see_clients_from_other_tenant()
    {
        // Create another tenant
        $otherTenant = Tenant::create(['id' => 'other-tenant']);
        $otherTenant->domains()->create(['domain' => 'other.localhost']);

        // Create client for other tenant
        tenancy()->initialize($otherTenant);
        Client::create([
            'name' => 'Other Client',
            'tenant_id' => $otherTenant->id,
        ]);
        tenancy()->end();

        // Switch back to main tenant
        tenancy()->initialize($this->tenant);

        // Create client for main tenant
        Client::create([
            'name' => 'My Client',
            'tenant_id' => $this->tenant->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('tenant.clients.index'));

        $response->assertSee('My Client');
        $response->assertDontSee('Other Client');
    }
}
