<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\PaymentLog;
use App\Models\Subscription;
use App\Services\Payment\AsaasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    protected AsaasService $asaasService;

    public function __construct(AsaasService $asaasService)
    {
        $this->asaasService = $asaasService;
    }

    /**
     * Handle Asaas webhook
     */
    public function asaas(Request $request)
    {
        try {
            // Validate webhook token
            $token = $request->header('asaas-access-token');
            if ($token !== config('services.asaas.webhook_token')) {
                Log::warning('Invalid Asaas webhook token');
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $payload = $request->all();
            $webhookData = $this->asaasService->processWebhook($payload);

            // Log the webhook
            Log::info('Asaas Webhook Received', $webhookData);

            // Find invoice by external reference or payment ID
            $invoice = null;
            if ($webhookData['external_reference']) {
                $invoice = Invoice::where('invoice_number', $webhookData['external_reference'])->first();
            }

            if (!$invoice && $webhookData['payment_id']) {
                $invoice = Invoice::where('asaas_invoice_id', $webhookData['payment_id'])->first();
            }

            if (!$invoice) {
                Log::warning('Invoice not found for webhook', $webhookData);
                return response()->json(['message' => 'Invoice not found'], 404);
            }

            // Create payment log
            PaymentLog::create([
                'invoice_id' => $invoice->id,
                'gateway' => 'asaas',
                'gateway_transaction_id' => $webhookData['payment_id'],
                'amount' => $webhookData['value'],
                'status' => $webhookData['status'],
                'response_data' => $webhookData['data'],
            ]);

            // Process based on event type
            switch ($webhookData['event']) {
                case 'PAYMENT_CONFIRMED':
                case 'PAYMENT_RECEIVED':
                    $this->handlePaymentConfirmed($invoice, $webhookData);
                    break;

                case 'PAYMENT_OVERDUE':
                    $this->handlePaymentOverdue($invoice);
                    break;

                case 'PAYMENT_DELETED':
                case 'PAYMENT_REFUNDED':
                    $this->handlePaymentCanceled($invoice);
                    break;
            }

            return response()->json(['message' => 'Webhook processed'], 200);

        } catch (\Exception $e) {
            Log::error('Webhook processing error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Internal error'], 500);
        }
    }

    /**
     * Handle confirmed payment
     */
    protected function handlePaymentConfirmed(Invoice $invoice, array $webhookData)
    {
        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
            'payment_method' => 'asaas',
        ]);

        // Update subscription status if exists
        if ($invoice->subscription_id) {
            $subscription = Subscription::find($invoice->subscription_id);
            if ($subscription && $subscription->status === 'trial') {
                $subscription->update(['status' => 'active']);
            }
        }

        // Send payment confirmation email
        try {
            \Mail::to($invoice->tenant->id . '@example.com')->send(new \App\Mail\PaymentConfirmed($invoice));
        } catch (\Exception $e) {
            Log::error('Failed to send payment confirmation email: ' . $e->getMessage());
        }

        Log::info("Payment confirmed for invoice {$invoice->invoice_number}");
    }

    /**
     * Handle overdue payment
     */
    protected function handlePaymentOverdue(Invoice $invoice)
    {
        $invoice->update(['status' => 'failed']);

        // TODO: Send overdue notification email
        // Mail::to($invoice->tenant->email)->send(new PaymentOverdue($invoice));

        Log::info("Payment overdue for invoice {$invoice->invoice_number}");
    }

    /**
     * Handle canceled/refunded payment
     */
    protected function handlePaymentCanceled(Invoice $invoice)
    {
        $invoice->update(['status' => 'canceled']);

        Log::info("Payment canceled for invoice {$invoice->invoice_number}");
    }
}
