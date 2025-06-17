<?php

namespace App\Services;

use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminApprovalService
{
    public function approve(Request $request): bool
    {
        $request->validate([
            'id' => 'required|exists:inventories,id',
        ]);

        $inventory = Inventory::findOrFail($request->id);
        $user = Auth::user();

        if (!$inventory->approved_by) {
            $inventory->approved_by = $user->name;
            $inventory->approved_date = now();
            $inventory->save();
        }

        return true;
    }
}
