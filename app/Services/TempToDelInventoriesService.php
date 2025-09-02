<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\ArchiveInventories;
use Illuminate\Support\Facades\DB;

class TempToDelInventoriesService
{
    /**
     * Get all countries.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function toArchiveInventoryAndDelete($inventoryId)
    {
        $inventory = Inventory::with('items')->findOrFail($inventoryId);

        DB::transaction(function() use ($inventory) {
            $inventory->disposal_status = 'disposed';
            // Create archived inventory
            $archived = ArchiveInventories::create($inventory->only([
                'office_origin',
                'prepared_by',
                'list_no',
                'series_no',
                'loc_code',
                'recieved_by',
                'recieved_date',
                'manager_approval',
                'approved_by',
                'approved_date',
                'disposal_status',
                'disposed_date',
                'user_id',
                'office_id'
            ]));

            // Archive items
            foreach ($inventory->items as $item) {
                $archived->items()->create([
                    'item_no' => $item->item_no,
                    'description' => $item->description,
                    'doc_date' => $item->doc_date,
                    'quantity_code' => $item->quantity_code,
                    'index_code' => $item->index_code,
                    'status' => $item->status,
                    'retention_period' => $item->retention_period,
                    'disposal_date' => $item->disposal_date,
                ]);
            }

            // Delete original
            $inventory->items()->delete();
            $inventory->delete();
        });
    }
}
