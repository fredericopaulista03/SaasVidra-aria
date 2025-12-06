<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Installation;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $start = $request->get('start');
            $end = $request->get('end');

            $installations = Installation::with(['order.client'])
                ->whereBetween('scheduled_at', [$start, $end])
                ->get()
                ->map(function ($installation) {
                    return [
                        'id' => $installation->id,
                        'title' => 'Instalação - ' . ($installation->order->client->name ?? 'Cliente'),
                        'start' => $installation->scheduled_at->toIso8601String(),
                        'url' => '#', // Link to order or installation details
                        'className' => 'bg-blue-500 text-white border-0'
                    ];
                });

            return response()->json($installations);
        }

        return view('tenant.schedule.index');
    }
}
