<?php

namespace App\Http\Controllers\Landlord;

use App\Models\Subscription;
use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscription::with(['tenant', 'plan']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('plan_id')) {
            $query->where('plan_id', $request->plan_id);
        }

        $subscriptions = $query->latest()->paginate(20);
        $plans = Plan::active()->get();

        return view('landlord.subscriptions.index', compact('subscriptions', 'plans'));
    }

    public function create()
    {
        $tenants = Tenant::all();
        $plans = Plan::active()->get();
        return view('landlord.subscriptions.create', compact('tenants', 'plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|in:trial,active,canceled,expired,suspended',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after:starts_at',
            'trial_ends_at' => 'nullable|date',
        ]);

        Subscription::create($validated);

        return redirect()->route('landlord.subscriptions.index')
            ->with('success', 'Assinatura criada com sucesso!');
    }

    public function show(Subscription $subscription)
    {
        $subscription->load(['tenant', 'plan', 'invoices']);
        return view('landlord.subscriptions.show', compact('subscription'));
    }

    public function edit(Subscription $subscription)
    {
        $plans = Plan::active()->get();
        return view('landlord.subscriptions.edit', compact('subscription', 'plans'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|in:trial,active,canceled,expired,suspended',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after:starts_at',
            'trial_ends_at' => 'nullable|date',
        ]);

        $subscription->update($validated);

        return redirect()->route('landlord.subscriptions.index')
            ->with('success', 'Assinatura atualizada!');
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return redirect()->route('landlord.subscriptions.index')
            ->with('success', 'Assinatura excluída!');
    }
}
