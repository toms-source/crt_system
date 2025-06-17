<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\ArchiveInventories;

class TempToDelInventoriesService
{
    /**
     * Get all countries.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    
    public function toArchiveInventoryAndDelete(Inventory $inventory)
    {
        ArchiveInventories::create([
            'original_id'       => $inventory->id,
            'description'       => $inventory->description,
            'doc_date'          => $inventory->doc_date,
            'quantity_code'     => $inventory->quantity_code,
            'index_code'        => $inventory->index_code,
            'status'            => $inventory->status,
            'retention_period'  => $inventory->retention_period,
            'disposal_date'     => $inventory->disposal_date,
            'office_origin'     => $inventory->office_origin,
            'prepared_by'       => $inventory->prepared_by,
            'list_no'           => $inventory->list_no,
            'series_no'         => $inventory->series_no,
            'loc_code'          => $inventory->loc_code,
            'recieved_by'       => $inventory->recieved_by,
            'recieve_date'      => $inventory->recieve_date,
            'manager_approval'  => $inventory->manager_approval,
            'approved_by'       => $inventory->approved_by,
            'approved_date'     => $inventory->approved_date,
            'user_id'           => $inventory->user_id,
            'office_id'         => $inventory->office_id,
        ]);

        $inventory->delete();

        return true;
    }
}
