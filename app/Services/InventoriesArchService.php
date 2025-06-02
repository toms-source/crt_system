<?php

namespace App\Services;

use App\Models\ArchiveInventories;
use Carbon\Carbon;

class InventoriesArchService
{

    /**
     * Get all countries.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return ArchiveInventories::all()->map(function ($item) {
            $item->disposal_date = Carbon::parse($item->disposal_date)->format('Y');
            return $item;
        });
    }
}
