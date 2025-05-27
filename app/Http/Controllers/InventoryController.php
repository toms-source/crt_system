<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Inventory;
use Spatie\Permission\Traits\HasRoles;

class InventoryController extends Controller
{
    public function view()
    {
        return view('user.form');
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

        // return redirect()->back()->with('success', 'Inventory record saved!');
        return redirect()->route('user.index')->with('success', 'Inventory record saved!');
    }
    //
    public function display(Request $request)
    {


        if ($request->ajax()) {
            $data = Inventory::whereNotNull('manager_approval');

            // $data = Inventory::query();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $inventoryJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');

                    return '
        <button 
            x-data 
            x-on:click="$dispatch(\'open-modal\', { inventory: ' . $inventoryJson . ' })"
            class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700 transition"
        >
            View
        </button>

        <button 
                x-data 
                x-on:click="$dispatch(\'edit-modal\', { inventory: ' . $inventoryJson . ' })"
                class="inline-flex items-center px-3 py-1 bg-green-600 text-white text-xs font-semibold rounded hover:bg-green-700 transition"
            >
                Edit
            </button>
            <button class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded hover:bg-red-700 transition">
                <a href="' . route('print-pdf', $row->id) . '" 
                target="_blank">Pdf</a> 
            </button>
    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.index');
    }

    public function displayIndexUser()
    {

        $user = Auth::user();
        // $inventories = Inventory::with('manager')->get();
        $inventories = Inventory::with('owner')
            ->where('user_id', Auth::id())
            ->get();


        return view('user.index', compact('inventories'));
    }

    public function displayIndexManager(Request $request)
    {

        if ($request->ajax()) {
            $data = Inventory::with('user')
                ->whereHas('user', function ($query) {
                    $query->where('managerId', Auth::id());
                });

            return DataTables::of($data)
                ->addIndexColumn()
                
                ->addColumn('prepared_by', function ($row) {
                    return $row->user->name ?? 'N/A';
                })

                ->editColumn('disposal_date', function($row) {
                    return $row->disposal_date ? Carbon::parse($row->disposal_date)->format('Y') : '';
                })
                ->addColumn('action', function ($row) {
                    $inventoryJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');

                    return '
        <button 
            x-data 
            x-on:click="$dispatch(\'open-modal\', { inventory: ' . $inventoryJson . ' })"
            class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700 transition"
        >
            View
        </button>
    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('manager.index');
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
}
