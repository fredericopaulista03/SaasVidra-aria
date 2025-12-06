<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use Illuminate\Http\Request;

class ClientPortalController extends Controller
{
    public function show(Request $request, Budget $budget)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Este link expirou ou é inválido.');
        }

        $budget->load(['client', 'items.product', 'items.measure']);

        return view('client-portal.budgets.show', compact('budget'));
    }

    public function approve(Request $request, Budget $budget)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Este link expirou ou é inválido.');
        }

        $budget->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Orçamento aprovado com sucesso! Entraremos em contato em breve.');
    }

    public function reject(Request $request, Budget $budget)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Este link expirou ou é inválido.');
        }

        $budget->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Orçamento rejeitado. Obrigado pelo feedback.');
    }
}
