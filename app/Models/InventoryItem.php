<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    //
    protected $fillable = [
        'item_no',
        'description',
        'doc_date',
        'quantity_code',
        'index_code',
        'status',
        'retention_period',
        'disposal_date',
        'inventory_id',
    ];
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
