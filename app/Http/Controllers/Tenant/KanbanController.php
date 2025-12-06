<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\KanbanCard;
use App\Models\KanbanColumn;
use Illuminate\Http\Request;

class KanbanController extends Controller
{
    public function index()
    {
        $columns = KanbanColumn::with(['cards.budget.client', 'cards.order.client'])
            ->orderBy('order_index')
            ->get();

        return view('tenant.kanban.index', compact('columns'));
    }

    public function update(Request $request, KanbanCard $card)
    {
        $validated = $request->validate([
            'kanban_column_id' => 'required|exists:kanban_columns,id',
            'order_index' => 'required|integer',
        ]);

        // Ensure the column belongs to the current tenant (handled by BelongsToTenant trait on Column model query, 
        // but we should check if the column ID passed actually belongs to the tenant)
        $column = KanbanColumn::findOrFail($validated['kanban_column_id']);

        $card->update([
            'kanban_column_id' => $column->id,
            'order_index' => $validated['order_index'],
        ]);

        return response()->json(['success' => true]);
    }
}
