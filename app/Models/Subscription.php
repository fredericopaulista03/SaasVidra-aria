<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'tenant_subscriptions';

    protected $fillable = [
        'tenant_id',
        'plan_id',
        'status',
        'starts_at',
        'ends_at',
        'trial_ends_at',
        'canceled_at',
        'asaas_subscription_id',
        'stripe_subscription_id',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'canceled_at' => 'datetime',
    ];

    /**
     * Get the tenant that owns the subscription
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the plan for this subscription
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get all invoices for this subscription
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Check if subscription is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if subscription is on trial
     */
    public function isOnTrial(): bool
    {
        return $this->status === 'trial' && 
               $this->trial_ends_at && 
               $this->trial_ends_at->isFuture();
    }

    /**
     * Check if subscription is expired
     */
    public function isExpired(): bool
    {
        return $this->status === 'expired' || 
               ($this->ends_at && $this->ends_at->isPast());
    }

    /**
     * Scope to get active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get trial subscriptions
     */
    public function scopeTrial($query)
    {
        return $query->where('status', 'trial');
    }
}
