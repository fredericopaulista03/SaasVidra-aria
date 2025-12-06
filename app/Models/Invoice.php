<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'subscription_id',
        'invoice_number',
        'amount',
        'status',
        'due_date',
        'paid_at',
        'payment_method',
        'asaas_invoice_id',
        'stripe_invoice_id',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the tenant that owns the invoice
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the subscription for this invoice
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Get all payment logs for this invoice
     */
    public function paymentLogs()
    {
        return $this->hasMany(PaymentLog::class);
    }

    /**
     * Check if invoice is paid
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Check if invoice is overdue
     */
    public function isOverdue(): bool
    {
        return $this->status === 'pending' && $this->due_date->isPast();
    }

    /**
     * Mark invoice as paid
     */
    public function markAsPaid(string $paymentMethod = null)
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
            'payment_method' => $paymentMethod,
        ]);
    }

    /**
     * Scope to get pending invoices
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get paid invoices
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope to get overdue invoices
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'pending')
                     ->where('due_date', '<', now());
    }

    /**
     * Generate unique invoice number
     */
    public static function generateInvoiceNumber(): string
    {
        $year = now()->year;
        $month = now()->format('m');
        $lastInvoice = static::whereYear('created_at', $year)
                            ->whereMonth('created_at', $month)
                            ->latest('id')
                            ->first();
        
        $sequence = $lastInvoice ? ((int) substr($lastInvoice->invoice_number, -4)) + 1 : 1;
        
        return sprintf('INV-%s%s-%04d', $year, $month, $sequence);
    }
}
