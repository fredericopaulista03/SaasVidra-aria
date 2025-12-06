<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\Client;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        // For simplicity, we'll just show the latest messages.
        // In a real app, we'd group by client/contact.
        $messages = ChatMessage::with('client')->latest()->take(50)->get()->reverse();
        $clients = Client::orderBy('name')->get();

        return view('tenant.chat.index', compact('messages', 'clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'content' => 'required|string',
        ]);

        // 1. Save Outbound Message
        $message = ChatMessage::create([
            'client_id' => $validated['client_id'],
            'direction' => 'outbound',
            'content' => $validated['content'],
            'status' => 'sent',
        ]);

        // 2. Send to Evolution API (Mocked)
        // Http::post('evolution-api-url', ...);

        return redirect()->route('tenant.chat.index')
            ->with('success', 'Mensagem enviada!');
    }

    public function webhook(Request $request)
    {
        // Handle incoming webhook from Evolution API
        // This would be a public route, but we need to identify the tenant.
        // For now, we'll skip this implementation as it requires external setup.
        return response()->json(['status' => 'ok']);
    }
}
