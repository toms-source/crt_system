<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveInventories extends Model
{
    //
      protected $fillable = [
        'original_id',
        'description',
        'doc_date',
        'quantity_code',
        'index_code',
        'status',
        'retention_period',
        'disposal_date',
        'office_origin',
        'prepared_by',
        'list_no',
        'series_no',
        'loc_code',
        'recieved_by',
        'recieve_date',
        'manager_approval',
        'approved_by',
        'approved_date',
        'user_id',
        'office_id',
    ];

    // Many-to-One: Inventory belongs to one user (owner)
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
