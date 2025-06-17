<?php

namespace App\Services;

use App\Models\Inventory;

class CheckUpdateInventoryService
{
    public function checkUpdate(int $id, array $data): bool
    {
        $inventory = Inventory::findOrFail($id);

        $inventory->update([
            'series_no' => $data['series_no'],
            'loc_code' => $data['loc_code'],
        ]);

        return true;
    }
}
