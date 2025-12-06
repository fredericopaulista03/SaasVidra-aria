<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KanbanCard extends Model
{
    use HasFactory, BelongsToTenant;

    protected $guarded = [];

    public function column()
    {
        return $this->belongsTo(KanbanColumn::class, 'kanban_column_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
