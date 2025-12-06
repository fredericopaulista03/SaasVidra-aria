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
            'company_name' => 'required|string|max:255',
            'name' => 'required|string|max:255', // Owner Name
            'email' => 'required|email|max:255|unique:users,email',
            'owner_phone' => 'required|string|max:20',
            'document' => 'required|string|max:18', // CPF or CNPJ
            'website' => 'nullable|url|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($validated) {
            // 1. Generate unique tenant ID from company name
            $baseSlug = \Illuminate\Support\Str::slug($validated['company_name']);
            $tenantId = $baseSlug;
            $counter = 1;
            
            // Ensure uniqueness
            while (Tenant::where('id', $tenantId)->exists()) {
                $tenantId = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            // 2. Create Tenant with company data
            $tenant = Tenant::create([
                'id' => $tenantId,
                'website' => $validated['website'] ?? null,
                'owner_phone' => $validated['owner_phone'],
                'document' => $validated['document'],
                'data' => [
                    'company_name' => $validated['company_name'],
                ],
            ]);

            // 4. Create Admin User for Tenant
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

        return redirect()->route('landlord.empresas.index')
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

        return redirect()->route('landlord.empresas.index')
            ->with('success', 'Tenant suspenso com sucesso!');
    }

    /**
     * Activate a tenant
     */
    public function activate(Tenant $tenant)
    {
        $tenant->update(['status' => 'active']);

        return redirect()->route('landlord.empresas.index')
            ->with('success', 'Tenant ativado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        // Check if tenant has active subscriptions
        if ($tenant->subscriptions()->where('status', 'active')->exists()) {
            return redirect()->route('landlord.empresas.index')
                ->with('error', 'Não é possível excluir um tenant com assinaturas ativas. Cancele as assinaturas primeiro.');
        }

        $tenant->delete();
        // User deletion should cascade or be handled manually if not set up in DB
        // In Single DB, we should delete users with this tenant_id
        User::where('tenant_id', $tenant->id)->delete();

        return redirect()->route('landlord.empresas.index')
            ->with('success', 'Vidraçaria excluída com sucesso!');
    }
}
