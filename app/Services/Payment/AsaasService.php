<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AsaasService implements PaymentGatewayInterface
{
    protected string $apiKey;
    protected string $baseUrl;
    protected bool $isSandbox;

    public function __construct()
    {
        $this->apiKey = config('services.asaas.api_key');
        $this->isSandbox = config('services.asaas.environment') === 'sandbox';
        $this->baseUrl = $this->isSandbox 
            ? 'https://sandbox.asaas.com/api/v3'
            : 'https://www.asaas.com/api/v3';
    }

    /**
     * Create a customer in Asaas
     */
    public function createCustomer(array $data): array
    {
        try {
            $response = Http::withHeaders([
                'access_token' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/customers", [
                'name' => $data['name'],
                'email' => $data['email'],
                'cpfCnpj' => $data['document'] ?? null,
                'phone' => $data['phone'] ?? null,
                'mobilePhone' => $data['mobile_phone'] ?? null,
                'address' => $data['address'] ?? null,
                'addressNumber' => $data['address_number'] ?? null,
                'complement' => $data['complement'] ?? null,
                'province' => $data['province'] ?? null,
                'postalCode' => $data['postal_code'] ?? null,
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'customer_id' => $response->json('id'),
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'error' => $response->json('errors')[0]['description'] ?? 'Erro ao criar cliente',
            ];
        } catch (\Exception $e) {
            Log::error('Asaas createCustomer error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Create a subscription in Asaas
     */
    public function createSubscription(array $data): array
    {
        try {
            $response = Http::withHeaders([
                'access_token' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/subscriptions", [
                'customer' => $data['customer_id'],
                'billingType' => $data['billing_type'] ?? 'BOLETO',
                'value' => $data['value'],
                'nextDueDate' => $data['next_due_date'],
                'cycle' => $data['cycle'] ?? 'MONTHLY',
                'description' => $data['description'] ?? null,
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'subscription_id' => $response->json('id'),
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'error' => $response->json('errors')[0]['description'] ?? 'Erro ao criar assinatura',
            ];
        } catch (\Exception $e) {
            Log::error('Asaas createSubscription error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Create a single charge/payment
     */
    public function createCharge(array $data): array
    {
        try {
            $response = Http::withHeaders([
                'access_token' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/payments", [
                'customer' => $data['customer_id'],
                'billingType' => $data['billing_type'] ?? 'BOLETO',
                'value' => $data['value'],
                'dueDate' => $data['due_date'],
                'description' => $data['description'] ?? null,
                'externalReference' => $data['external_reference'] ?? null,
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'payment_id' => $response->json('id'),
                    'invoice_url' => $response->json('invoiceUrl'),
                    'bank_slip_url' => $response->json('bankSlipUrl'),
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'error' => $response->json('errors')[0]['description'] ?? 'Erro ao criar cobrança',
            ];
        } catch (\Exception $e) {
            Log::error('Asaas createCharge error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Cancel a subscription
     */
    public function cancelSubscription(string $subscriptionId): bool
    {
        try {
            $response = Http::withHeaders([
                'access_token' => $this->apiKey,
            ])->delete("{$this->baseUrl}/subscriptions/{$subscriptionId}");

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Asaas cancelSubscription error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get payment status
     */
    public function getPaymentStatus(string $paymentId): array
    {
        try {
            $response = Http::withHeaders([
                'access_token' => $this->apiKey,
            ])->get("{$this->baseUrl}/payments/{$paymentId}");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'status' => $response->json('status'),
                    'data' => $response->json(),
                ];
            }

            return ['success' => false, 'error' => 'Pagamento não encontrado'];
        } catch (\Exception $e) {
            Log::error('Asaas getPaymentStatus error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Process webhook notification
     */
    public function processWebhook(array $payload): array
    {
        $event = $payload['event'] ?? null;
        $payment = $payload['payment'] ?? [];

        return [
            'event' => $event,
            'payment_id' => $payment['id'] ?? null,
            'status' => $payment['status'] ?? null,
            'value' => $payment['value'] ?? 0,
            'customer' => $payment['customer'] ?? null,
            'external_reference' => $payment['externalReference'] ?? null,
            'data' => $payload,
        ];
    }
}
