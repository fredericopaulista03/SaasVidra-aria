<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KanbanColumn extends Model
{
    use HasFactory, BelongsToTenant;

    protected $guarded = [];

    public function cards()
    {
        return $this->hasMany(KanbanCard::class)->orderBy('order_index');
    }
}
