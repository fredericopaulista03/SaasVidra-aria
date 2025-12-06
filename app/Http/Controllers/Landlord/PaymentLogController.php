<?php

namespace App\Http\Controllers\Landlord;

use App\Models\PaymentLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentLogController extends Controller
{
    public function index(Request $request)
    {
        $query = PaymentLog::with('invoice.tenant');

        if ($request->filled('gateway')) {
            $query->where('gateway', $request->gateway);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $logs = $query->latest()->paginate(30);

        return view('landlord.payment-logs.index', compact('logs'));
    }
}
