<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->tenant_id) {
            // Tenant User
            $currentMonth = now()->month;
            $currentYear = now()->year;

            // Financial Stats
            $revenue = \App\Models\FinancialTransaction::where('type', 'income')
                ->whereMonth('due_date', $currentMonth)
                ->whereYear('due_date', $currentYear)
                ->sum('amount');

            $expense = \App\Models\FinancialTransaction::where('type', 'expense')
                ->whereMonth('due_date', $currentMonth)
                ->whereYear('due_date', $currentYear)
                ->sum('amount');

            // Budget Stats
            $budgetStats = \App\Models\Budget::selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();

            $totalClients = \App\Models\Client::count();

            return view('tenant.dashboard', [
                'user' => $user,
                'revenue' => $revenue,
                'expense' => $expense,
                'budgetStats' => $budgetStats,
                'totalClients' => $totalClients
            ]);
        } else {
            // Landlord User (Super Admin)
            $stats = [
                'total_tenants' => \App\Models\Tenant::count(),
                'recent_tenants' => \App\Models\Tenant::latest()->take(5)->get(),
            ];
            return view('landlord.dashboard', ['user' => $user, 'stats' => $stats]);
        }
    }
}
