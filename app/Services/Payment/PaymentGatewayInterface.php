<?php

namespace App\Services\Payment;

interface PaymentGatewayInterface
{
    /**
     * Create a customer in the payment gateway
     */
    public function createCustomer(array $data): array;

    /**
     * Create a subscription
     */
    public function createSubscription(array $data): array;

    /**
     * Create a single charge/invoice
     */
    public function createCharge(array $data): array;

    /**
     * Cancel a subscription
     */
    public function cancelSubscription(string $subscriptionId): bool;

    /**
     * Get payment status
     */
    public function getPaymentStatus(string $paymentId): array;

    /**
     * Process webhook notification
     */
    public function processWebhook(array $payload): array;
}
