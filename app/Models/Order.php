<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, BelongsToTenant;

    protected $guarded = [];

    protected $casts = [
        'scheduled_date' => 'date',
        'delivery_date' => 'date',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function installation()
    {
        return $this->hasOne(Installation::class);
    }

    public function financialTransactions()
    {
        return $this->hasMany(FinancialTransaction::class);
    }
}
