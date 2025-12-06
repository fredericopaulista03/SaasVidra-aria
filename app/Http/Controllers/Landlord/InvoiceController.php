<?php

namespace App\Http\Controllers\Landlord;

use App\Models\Invoice;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['tenant', 'subscription']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        $invoices = $query->latest()->paginate(20);
        $tenants = Tenant::all();

        return view('landlord.invoices.index', compact('invoices', 'tenants'));
    }

    public function create()
    {
        $tenants = Tenant::all();
        $subscriptions = Subscription::with('tenant')->get();
        return view('landlord.invoices.create', compact('tenants', 'subscriptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'subscription_id' => 'nullable|exists:tenant_subscriptions,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['invoice_number'] = Invoice::generateInvoiceNumber();
        $validated['status'] = 'pending';

        Invoice::create($validated);

        return redirect()->route('landlord.invoices.index')
            ->with('success', 'Fatura criada com sucesso!');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['tenant', 'subscription', 'paymentLogs']);
        return view('landlord.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        return view('landlord.invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,paid,failed,refunded,canceled',
            'notes' => 'nullable|string',
        ]);

        $invoice->update($validated);

        return redirect()->route('landlord.invoices.index')
            ->with('success', 'Fatura atualizada!');
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return redirect()->route('landlord.invoices.index')
                ->with('error', 'Não é possível excluir uma fatura paga.');
        }

        $invoice->delete();
        return redirect()->route('landlord.invoices.index')
            ->with('success', 'Fatura excluída!');
    }
}
