<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\FinancialTransaction;
use Illuminate\Http\Request;

class FinancialTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = FinancialTransaction::with('client')->latest('due_date');

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('status')) {
            if ($request->status === 'paid') {
                $query->whereNotNull('paid_at');
            } elseif ($request->status === 'pending') {
                $query->whereNull('paid_at');
            }
        }

        $transactions = $query->paginate(15);
        
        $totalIncome = FinancialTransaction::where('type', 'income')->sum('amount');
        $totalExpense = FinancialTransaction::where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('tenant.finance.index', compact('transactions', 'totalIncome', 'totalExpense', 'balance'));
    }

    public function create()
    {
        $clients = Client::orderBy('name')->get();
        return view('tenant.finance.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'client_id' => 'nullable|exists:clients,id',
            'paid_at' => 'nullable|date',
        ]);

        FinancialTransaction::create($validated);

        return redirect()->route('tenant.finance.index')
            ->with('success', 'Lançamento criado com sucesso!');
    }

    public function edit(FinancialTransaction $financialTransaction)
    {
        // Route model binding automatically scopes to tenant via BelongsToTenant trait?
        // We should verify if standard binding works with the global scope. Yes, it should.
        $clients = Client::orderBy('name')->get();
        return view('tenant.finance.edit', [
            'transaction' => $financialTransaction,
            'clients' => $clients
        ]);
    }

    public function update(Request $request, FinancialTransaction $financialTransaction)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'client_id' => 'nullable|exists:clients,id',
            'paid_at' => 'nullable|date',
        ]);

        $financialTransaction->update($validated);

        return redirect()->route('tenant.finance.index')
            ->with('success', 'Lançamento atualizado com sucesso!');
    }

    public function destroy(FinancialTransaction $financialTransaction)
    {
        $financialTransaction->delete();
        return redirect()->route('tenant.finance.index')
            ->with('success', 'Lançamento excluído com sucesso!');
    }
}
