<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //
    protected $table = 'inventories';

    protected $fillable = [
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
        'approved_by',
        'approved_date',
        'user_id',
        'office_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Many-to-One: Inventory belongs to one user (owner)
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Many-to-One: Inventory belongs to one office
    public function office()
    {
        return $this->belongsTo(Offices::class, 'office_id');
    }
    public function manager()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Many-to-Many: Inventory can be manipulated by many users
    public function manipulators()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
