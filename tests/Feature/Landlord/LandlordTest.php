<?php

namespace Tests\Feature\Landlord;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandlordTest extends TestCase
{
    use RefreshDatabase;

    protected $landlord;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Landlord User (No tenant_id)
        $this->landlord = User::factory()->create([
            'tenant_id' => null,
        ]);
    }

    public function test_landlord_can_view_dashboard()
    {
        $response = $this->actingAs($this->landlord)
            ->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('landlord.dashboard');
        $response->assertSee('Painel do Administrador');
    }

    public function test_landlord_can_create_tenant()
    {
        $tenantData = [
            'id' => 'new-tenant',
            'name' => 'New Tenant Owner',
            'email' => 'new@tenant.com',
            'domain' => 'new.localhost',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->actingAs($this->landlord)
            ->post(route('landlord.tenants.store'), $tenantData);

        $response->assertRedirect(route('landlord.tenants.index'));
        
        $this->assertDatabaseHas('tenants', ['id' => 'new-tenant']);
        $this->assertDatabaseHas('domains', ['domain' => 'new.localhost']);
        $this->assertDatabaseHas('users', ['email' => 'new@tenant.com', 'tenant_id' => 'new-tenant']);
    }

    public function test_landlord_can_list_tenants()
    {
        // Create a tenant
        $tenant = Tenant::create(['id' => 'existing-tenant']);
        $tenant->domains()->create(['domain' => 'existing.localhost']);

        $response = $this->actingAs($this->landlord)
            ->get(route('landlord.tenants.index'));

        $response->assertStatus(200);
        $response->assertSee('existing-tenant');
        $response->assertSee('existing.localhost');
    }

    public function test_landlord_can_delete_tenant()
    {
        $tenant = Tenant::create(['id' => 'to-delete']);
        $tenant->domains()->create(['domain' => 'delete.localhost']);
        User::create([
            'name' => 'Owner',
            'email' => 'delete@owner.com',
            'password' => 'password',
            'tenant_id' => 'to-delete',
        ]);

        $response = $this->actingAs($this->landlord)
            ->delete(route('landlord.tenants.destroy', $tenant));

        $response->assertRedirect(route('landlord.tenants.index'));
        
        $this->assertDatabaseMissing('tenants', ['id' => 'to-delete']);
        $this->assertDatabaseMissing('domains', ['domain' => 'delete.localhost']);
        // Users should also be deleted (handled in controller)
        $this->assertDatabaseMissing('users', ['email' => 'delete@owner.com']);
    }
}
