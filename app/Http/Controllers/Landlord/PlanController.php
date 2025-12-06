<?php

namespace App\Http\Controllers\Landlord;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    /**
     * Display a listing of plans
     */
    public function index()
    {
        $plans = Plan::ordered()->get();
        return view('landlord.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new plan
     */
    public function create()
    {
        return view('landlord.plans.create');
    }

    /**
     * Store a newly created plan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:plans',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,quarterly,semiannual,yearly',
            'features' => 'nullable|array',
            'max_users' => 'nullable|integer|min:1',
            'max_clients' => 'nullable|integer|min:1',
            'max_budgets' => 'nullable|integer|min:1',
            'trial_days' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        Plan::create($validated);

        return redirect()->route('landlord.plans.index')
            ->with('success', 'Plano criado com sucesso!');
    }

    /**
     * Display the specified plan
     */
    public function show(Plan $plan)
    {
        $plan->load('subscriptions.tenant');
        return view('landlord.plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified plan
     */
    public function edit(Plan $plan)
    {
        return view('landlord.plans.edit', compact('plan'));
    }

    /**
     * Update the specified plan
     */
    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:plans,slug,' . $plan->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,quarterly,semiannual,yearly',
            'features' => 'nullable|array',
            'max_users' => 'nullable|integer|min:1',
            'max_clients' => 'nullable|integer|min:1',
            'max_budgets' => 'nullable|integer|min:1',
            'trial_days' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $plan->update($validated);

        return redirect()->route('landlord.plans.index')
            ->with('success', 'Plano atualizado com sucesso!');
    }

    /**
     * Remove the specified plan
     */
    public function destroy(Plan $plan)
    {
        // Check if plan has active subscriptions
        if ($plan->activeSubscriptions()->exists()) {
            return redirect()->route('landlord.plans.index')
                ->with('error', 'Não é possível excluir um plano com assinaturas ativas.');
        }

        $plan->delete();

        return redirect()->route('landlord.plans.index')
            ->with('success', 'Plano excluído com sucesso!');
    }

    /**
     * Toggle plan active status
     */
    public function toggleStatus(Plan $plan)
    {
        $plan->update(['is_active' => !$plan->is_active]);

        return redirect()->route('landlord.plans.index')
            ->with('success', 'Status do plano atualizado!');
    }
}
