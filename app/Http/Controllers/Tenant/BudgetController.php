<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $budgets = Budget::with('client')->latest()->paginate(10);
        return view('tenant.budgets.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();
        return view('tenant.budgets.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'valid_until' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $budget = Budget::create([
            'client_id' => $validated['client_id'],
            'valid_until' => $validated['valid_until'] ?? now()->addDays(15),
            'status' => 'draft',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('tenant.budgets.edit', $budget)
            ->with('success', 'Orçamento iniciado! Adicione os itens agora.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
        $budget->load(['client', 'items.product']);
        $products = Product::orderBy('name')->get();
        
        return view('tenant.budgets.edit', compact('budget', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        // This method handles saving the entire budget state (items, totals, etc.)
        // Expecting a JSON payload or form data with items
        
        $validated = $request->validate([
            'payment_terms' => 'nullable|string',
            'notes' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0',
            'items' => 'array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.width' => 'nullable|numeric',
            'items.*.height' => 'nullable|numeric',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($budget, $validated) {
            // 1. Update Budget Details
            $budget->update([
                'payment_terms' => $validated['payment_terms'] ?? $budget->payment_terms,
                'notes' => $validated['notes'] ?? $budget->notes,
                'discount' => $validated['discount'] ?? 0,
            ]);

            // 2. Sync Items (Delete all and recreate - simpler for now)
            $budget->items()->delete();

            $total = 0;
            $subtotal = 0;

            if (isset($validated['items'])) {
                foreach ($validated['items'] as $itemData) {
                    $product = Product::find($itemData['product_id']);
                    
                    $width = $itemData['width'] ?? 0;
                    $height = $itemData['height'] ?? 0;
                    $quantity = $itemData['quantity'];
                    $unitPrice = $itemData['unit_price'];
                    
                    // Calculate Item Total
                    $itemTotal = 0;
                    if ($product->type === 'glass') {
                        // Glass Calculation: Width * Height * Price (assuming m2)
                        // In a real glazier app, we would apply rounding logic here (e.g., round to next 50mm)
                        // For now, exact calculation:
                        $area = ($width * $height) / 1000000; // mm to m2
                        // Minimum area check could go here (e.g. min 0.25m2)
                        $itemTotal = $area * $unitPrice * $quantity;
                    } else {
                        // Simple Unit Calculation
                        $itemTotal = $quantity * $unitPrice;
                    }

                    $budget->items()->create([
                        'product_id' => $product->id,
                        'description' => $product->name, // Snapshot of name
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total_price' => $itemTotal,
                        'width' => $width,
                        'height' => $height,
                    ]);

                    $subtotal += $itemTotal;
                }
            }

            // 3. Update Budget Totals
            $total = $subtotal - $budget->discount;
            $budget->update([
                'subtotal' => $subtotal,
                'total' => $total,
            ]);
        });

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Orçamento salvo com sucesso!', 'redirect' => route('tenant.budgets.index')]);
        }

        return redirect()->route('tenant.budgets.index')
            ->with('success', 'Orçamento salvo com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        $budget->load(['client', 'items.product']);
        return view('tenant.budgets.show', compact('budget'));
    }

    /**
     * Download budget as PDF.
     */
    public function downloadPdf(Budget $budget)
    {
        $budget->load(['client', 'items.product']);
        
        $pdf = Pdf::loadView('tenant.budgets.pdf', compact('budget'));
        
        $filename = 'orcamento-' . str_pad($budget->id, 6, '0', STR_PAD_LEFT) . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        $budget->items()->delete();
        $budget->delete();

        return redirect()->route('tenant.budgets.index')
            ->with('success', 'Orçamento excluído com sucesso!');
    }
}
