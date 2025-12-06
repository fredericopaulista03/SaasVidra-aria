<?php

namespace Tests\Feature\Tenant;

use App\Models\Budget;
use App\Models\Client;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class ClientPortalTest extends TestCase
{
    use RefreshDatabase;

    protected $tenant;
    protected $client;
    protected $budget;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Tenant
        $this->tenant = Tenant::create(['id' => 'test-tenant']);
        $this->tenant->domains()->create(['domain' => 'test.localhost']);

        // Initialize Tenancy
        tenancy()->initialize($this->tenant);

        // Create Client
        $this->client = Client::create([
            'name' => 'John Doe',
            'tenant_id' => $this->tenant->id,
        ]);

        // Create Budget
        $this->budget = Budget::create([
            'client_id' => $this->client->id,
            'tenant_id' => $this->tenant->id,
            'status' => 'sent',
            'total' => 1000.00,
        ]);
        
        // Force URL to tenant domain
        URL::forceRootUrl('http://' . $this->tenant->domains->first()->domain);
    }

    public function test_client_can_view_budget_with_signed_url()
    {
        $url = URL::signedRoute('tenant.portal.budget', $this->budget);

        $response = $this->get($url);

        $response->assertStatus(200);
        $response->assertSee('Orçamento #' . $this->budget->id);
        $response->assertSee('1.000,00');
    }

    public function test_client_cannot_view_budget_with_invalid_signature()
    {
        $url = route('tenant.portal.budget', $this->budget); // Unsigned

        $response = $this->get($url);

        $response->assertStatus(403);
    }

    public function test_client_can_approve_budget()
    {
        $url = URL::signedRoute('tenant.portal.approve', $this->budget);

        $response = $this->get($url);

        $response->assertRedirect();
        $this->assertDatabaseHas('budgets', [
            'id' => $this->budget->id,
            'status' => 'approved',
        ]);
    }

    public function test_client_can_reject_budget()
    {
        $url = URL::signedRoute('tenant.portal.reject', $this->budget);

        $response = $this->get($url);

        $response->assertRedirect();
        $this->assertDatabaseHas('budgets', [
            'id' => $this->budget->id,
            'status' => 'rejected',
        ]);
    }
}
