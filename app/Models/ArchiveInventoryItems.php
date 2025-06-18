<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveInventoryItems extends Model
{
    protected $fillable = [
        'item_no',
        'description',
        'doc_date',
        'quantity_code',
        'index_code',
        'status',
        'retention_period',
        'disposal_date',
        'archive_inventories_id',
    ];

    public function archiveInventory()
    {
        return $this->belongsTo(ArchiveInventories::class);
    }
}
