<?php

namespace App\Services;

use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

class UserInventoriesService 
{

    public function display() {
        return Inventory::with(['owner', 'items'])
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($inventory) {
                $inventory->items->transform(function ($item) {
                    $item->doc_date = \Carbon\Carbon::parse($item->doc_date)->format('m/d/Y');
                    return $item;
                });
                return $inventory;
            });
    }
    
}