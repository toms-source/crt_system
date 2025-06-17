<?php

namespace App\Services;

use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminRecievingService
{
    public function recieve(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:inventories,id',
        ]);

        $inventory = Inventory::findOrFail($request->id);
        $user = Auth::user();

        if (!$inventory->recieved_by) {
            $inventory->recieved_by = $user->name;
            $inventory->recieve_date = now();
            $inventory->save();
        }

        return true;
    }
}
