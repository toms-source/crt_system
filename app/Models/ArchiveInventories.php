<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveInventories extends Model
{
    //
    protected $fillable = [
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
        'disposal_status',
        'user_id',
        'office_id',
    ];

    // Many-to-One: Inventory belongs to one user (owner)
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function user() 
    {
        return $this->belongsTo(User::class);
    }
    public function items() 
    {
        return $this->hasMany(ArchiveInventoryItems::class);
    }
}
