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
            return view('tenant.dashboard', ['user' => $user]);
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
