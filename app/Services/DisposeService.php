<?php

namespace App\Services;

use App\Models\Inventory; 
use App\Models\ArchiveInventories;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DisposeService
{
    public function disposal($inventoryId) 
    {
        $inventory = Inventory::with('items')->findOrFail($inventoryId);

    DB::transaction(function () use ($inventory) {
        // Update disposal status and date
        $inventory->disposal_status = 'disposed';
        $inventory->disposed_date = now();

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

        // Archive related items
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

    return [
        'success' => true,
        'message' => 'Inventory disposed and archived successfully.'
    ];
    }
}