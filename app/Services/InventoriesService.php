<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\ArchiveInventories;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InventoriesService
{
    /**
     * Get all countries.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    
    public function getUserInventories()
    {
        return Inventory::with('owner')
            ->where('user_id', Auth::id())
            ->get();
    }
    public function createInventory(Request $request)
    {
        Validator::make($request->all(), [
            'description' => 'required|string|max:255',
            'quantity_code' => 'required|string|max:255',
            'doc_date' => 'required|digits:4',
            'index_code' => 'required|string|max:255',
            'status' => 'required|string|in:Permanent,Temporary',
            'retention_period' => 'required|integer|min:0',
        ]);

        $user = Auth::user();
        $docDate = Carbon::createFromFormat('Y', $request->doc_date)->startOfYear();
        $disposalDate = $docDate->copy()->addYears((int) $request->retention_period);

        Inventory::create([
            'description' => $request->description,
            'quantity_code' => $request->quantity_code,
            'doc_date' => Carbon::createFromFormat('Y', $request->doc_date)->startOfYear(),
            'index_code' => $request->index_code,
            'status' => $request->status,
            'retention_period' => $request->retention_period,
            'disposal_date' => $disposalDate,
            'office_origin' => $user->office->department ?? 'Unknown Office',
            'prepared_by' => $user->name,
            'user_id' => $user->id,
            'office_id' => $user->office_id,
        ]);

        return redirect()->route('user.index')->with('success', 'Inventory record saved!');
    }

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

    public function adminReceive(Request $request)
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

    public function managerApproval(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:inventories,id',
        ]);

        $inventory = Inventory::findOrFail($request->id);
        $user = Auth::user();

        // Approve only if not already approved
        if (!$inventory->manager_approval) {
            $inventory->manager_approval = $user->name;
            $inventory->save();
        }

        return true;
    }

    public function adminApproval(Request $request): bool
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
