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
                'active_subscriptions' => \App\Models\Subscription::where('status', 'active')->count(),
                'trial_subscriptions' => \App\Models\Subscription::where('status', 'trial')->count(),
                'total_revenue' => \App\Models\Invoice::where('status', 'paid')->sum('amount'),
                'pending_invoices' => \App\Models\Invoice::where('status', 'pending')->count(),
                'recent_subscriptions' => \App\Models\Subscription::with(['tenant', 'plan'])->latest()->take(5)->get(),
                'recent_invoices' => \App\Models\Invoice::with('tenant')->latest()->take(5)->get(),
            ];
            return view('landlord.dashboard', ['user' => $user, 'stats' => $stats]);
        }
    }
}
