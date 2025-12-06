<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measure extends Model
{
    use HasFactory, BelongsToTenant;

    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
