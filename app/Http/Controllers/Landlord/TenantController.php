<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::with('domains')->latest()->paginate(10);
        return view('landlord.tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('landlord.tenants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|alpha_dash|max:255|unique:tenants,id',
            'name' => 'required|string|max:255', // Owner Name
            'email' => 'required|email|max:255|unique:users,email',
            'domain' => 'required|string|max:255|unique:domains,domain',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($validated) {
            // 1. Create Tenant
            $tenant = Tenant::create(['id' => $validated['id']]);
            
            // 2. Create Domain
            $tenant->domains()->create(['domain' => $validated['domain']]);

            // 3. Create Admin User for Tenant
            // We need to initialize tenancy to create the user in the right context?
            // Actually, in Single Database mode, we just create the user with tenant_id.
            
            // However, we are currently in the Central context.
            // We can create the user directly.
            
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'tenant_id' => $tenant->id,
            ]);
            
            // Assign Role (assuming Spatie is set up globally or per tenant)
            // For Single DB, roles are usually in the same DB.
            // We need to ensure the role exists or assign it.
            // $user->assignRole('owner'); // This might require the role to exist for this tenant_id if using team_id
        });

        return redirect()->route('landlord.tenants.index')
            ->with('success', 'Vidraçaria criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        $tenant->load(['domains', 'subscriptions.plan', 'subscriptions.invoices']);
        return view('landlord.tenants.show', compact('tenant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Suspend a tenant
     */
    public function suspend(Tenant $tenant)
    {
        $tenant->update(['status' => 'suspended']);

        return redirect()->route('landlord.tenants.index')
            ->with('success', 'Tenant suspenso com sucesso!');
    }

    /**
     * Activate a tenant
     */
    public function activate(Tenant $tenant)
    {
        $tenant->update(['status' => 'active']);

        return redirect()->route('landlord.tenants.index')
            ->with('success', 'Tenant ativado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        // Check if tenant has active subscriptions
        if ($tenant->subscriptions()->where('status', 'active')->exists()) {
            return redirect()->route('landlord.tenants.index')
                ->with('error', 'Não é possível excluir um tenant com assinaturas ativas. Cancele as assinaturas primeiro.');
        }

        $tenant->delete();
        // User deletion should cascade or be handled manually if not set up in DB
        // In Single DB, we should delete users with this tenant_id
        User::where('tenant_id', $tenant->id)->delete();

        return redirect()->route('landlord.tenants.index')
            ->with('success', 'Vidraçaria excluída com sucesso!');
    }
}
