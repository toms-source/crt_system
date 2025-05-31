<?php

namespace App\Http\Controllers;

use App\Models\ArchiveInventories;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Offices;
use App\Models\User;
use App\Models\Inventory;

use function Pest\Laravel\delete;

class InventoryController extends Controller
{
    public function view()
    {
        return view('user.form');
    }
    public function displayRegister()
    {
        return view('manager.register');
    }

    public function create(Request $request)
    {
        $request->validate([
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
    

    public function displayIndexUser()
    {
        $user = Auth::user();
        $inventories = Inventory::with('owner')
            ->where('user_id', Auth::id())
            ->get();

        return view('user.index', compact('inventories'));
    }

    public function approve(Request $request)
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

        return redirect()->route('manager.index')->with('success', 'Inventory approved successfully.');
    }
    public function adminRecieve(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:inventories,id',
        ]);

        $inventory = Inventory::findOrFail($request->id);
        $user = Auth::user();

        // recieve only if not already recieved
        if (!$inventory->recieved_by) {
            $inventory->recieved_by = $user->name;
            $inventory->recieve_date = now();
            $inventory->save();
        }

        return redirect()->route('admin.index')->with('success', 'Inventory recieved successfully.');
    }

    public function adminApprove(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:inventories,id',
        ]);

        $inventory = Inventory::findOrFail($request->id);
        $user = Auth::user();

        // recieve only if not already recieved
        if (!$inventory->approved_by) {
            $inventory->approved_by = $user->name;
            $inventory->approved_date = now();
            $inventory->save();
        }

        return redirect()->route('admin.index')->with('success', 'Inventory recieved successfully.');
    }
    public function destroy(Inventory $inventory)
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

        return redirect()->back()->with('success', 'Inventory archived successfully.');
    }
    public function reports() 
    {
        $users = User::count()-1;
        $inventories = ArchiveInventories::count();
        $office = Offices::count();

        return view('admin.reports', compact('users', 'inventories', 'office'));
    }
}
