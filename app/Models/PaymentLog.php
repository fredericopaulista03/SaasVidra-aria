<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'gateway',
        'gateway_transaction_id',
        'amount',
        'status',
        'payment_method',
        'response_data',
        'error_message',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'response_data' => 'array',
    ];

    /**
     * Get the invoice that owns the payment log
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Check if payment was successful
     */
    public function isSuccessful(): bool
    {
        return in_array($this->status, ['paid', 'confirmed', 'received']);
    }

    /**
     * Check if payment failed
     */
    public function isFailed(): bool
    {
        return in_array($this->status, ['failed', 'refused', 'canceled']);
    }

    /**
     * Scope to get successful payments
     */
    public function scopeSuccessful($query)
    {
        return $query->whereIn('status', ['paid', 'confirmed', 'received']);
    }

    /**
     * Scope to get failed payments
     */
    public function scopeFailed($query)
    {
        return $query->whereIn('status', ['failed', 'refused', 'canceled']);
    }

    /**
     * Scope to filter by gateway
     */
    public function scopeGateway($query, string $gateway)
    {
        return $query->where('gateway', $gateway);
    }
}
