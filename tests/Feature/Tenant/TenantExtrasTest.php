<?php

namespace Tests\Feature\Tenant;

use App\Models\Client;
use App\Models\KanbanCard;
use App\Models\KanbanColumn;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class TenantExtrasTest extends TestCase
{
    use RefreshDatabase;

    protected $tenant;
    protected $user;
    protected $client;

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
        
        // Force URL to tenant domain
        URL::forceRootUrl('http://' . $this->tenant->domains->first()->domain);
    }

    public function test_tenant_can_view_kanban_board()
    {
        // Create columns
        $column = KanbanColumn::create(['name' => 'Pending', 'slug' => 'pending', 'order_index' => 1, 'tenant_id' => $this->tenant->id]);
        
        $response = $this->actingAs($this->user)
            ->get(route('tenant.kanban.index'));

        $response->assertStatus(200);
        $response->assertSee('Pending');
    }

    public function test_tenant_can_update_kanban_card_position()
    {
        $column1 = KanbanColumn::create(['name' => 'Col 1', 'slug' => 'col1', 'order_index' => 1, 'tenant_id' => $this->tenant->id]);
        $column2 = KanbanColumn::create(['name' => 'Col 2', 'slug' => 'col2', 'order_index' => 2, 'tenant_id' => $this->tenant->id]);
        
        $card = KanbanCard::create([
            'kanban_column_id' => $column1->id,
            'title' => 'Test Card',
            'order_index' => 1,
            'tenant_id' => $this->tenant->id,
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('tenant.kanban.update', $card), [
                'kanban_column_id' => $column2->id,
                'order_index' => 1,
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('kanban_cards', [
            'id' => $card->id,
            'kanban_column_id' => $column2->id,
        ]);
    }

    public function test_tenant_can_manage_finances()
    {
        // Create
        $response = $this->actingAs($this->user)
            ->post(route('tenant.finance.store'), [
                'description' => 'Income Test',
                'type' => 'income',
                'amount' => 100.00,
                'due_date' => now()->format('Y-m-d'),
                'client_id' => $this->client->id,
            ]);

        $response->assertRedirect(route('tenant.finance.index'));
        $this->assertDatabaseHas('financial_transactions', ['description' => 'Income Test']);

        // List
        $response = $this->actingAs($this->user)
            ->get(route('tenant.finance.index'));
        $response->assertSee('Income Test');
    }

    public function test_tenant_can_view_schedule()
    {
        $response = $this->actingAs($this->user)
            ->get(route('tenant.schedule.index'));

        $response->assertStatus(200);
        $response->assertSee('calendar');
    }

    public function test_tenant_can_send_chat_message()
    {
        $response = $this->actingAs($this->user)
            ->post(route('tenant.chat.store'), [
                'client_id' => $this->client->id,
                'content' => 'Hello World',
            ]);

        $response->assertRedirect(route('tenant.chat.index'));
        $this->assertDatabaseHas('chat_messages', [
            'content' => 'Hello World',
            'direction' => 'outbound',
            'client_id' => $this->client->id,
        ]);
    }
}
