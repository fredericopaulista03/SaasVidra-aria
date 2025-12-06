<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, BelongsToTenant;

    protected $guarded = [];

    public function measures()
    {
        return $this->hasMany(Measure::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
