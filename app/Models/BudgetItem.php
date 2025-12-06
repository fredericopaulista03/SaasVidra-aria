<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    use HasFactory, BelongsToTenant;

    protected $guarded = [];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function measure()
    {
        return $this->belongsTo(Measure::class);
    }
}
