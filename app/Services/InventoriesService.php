<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\ArchiveInventories;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class InventoriesService
{
    /**
     * Get all countries.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function getUserInventories()
    {
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
    public function createInventory(Request $request)
    {
        DB::beginTransaction();
        $user = Auth::user();

        try {
            // count the number of valid inventory item
            $validItems = collect($request->items)->filter(function ($item) {
                return !empty($item['description']) &&
                    !empty($item['doc_date']) &&
                    !empty($item['quantity_code']) &&
                    !empty($item['index_code']) &&
                    !empty($item['retention_period']);
            });

            $itemCount = $validItems->count();

            // Create the main inventory
            $inventory = Inventory::create([
                'office_origin' => $user->office->department ?? 'Unknown Office',
                'prepared_by' => $user->name,
                'list_no' => $itemCount,
                'user_id' => $user->id,
                'office_id' => $user->office_id,
            ]);

            // Store each valid inventory item
            foreach ($validItems->values() as $index => $item) {
                $docDate = Carbon::parse($item['doc_date'])->startOfYear();
                $disposalDate = $docDate->copy()->addYears((int) $item['retention_period']);
                $retention = (int) $item['retention_period'];

                $inventory->items()->create([
                    'item_no' => $index + 1,
                    'description' => $item['description'],
                    'doc_date' => $docDate,
                    'quantity_code' => $item['quantity_code'],
                    'index_code' => $item['index_code'],
                    'status' => $item['status'],
                    'retention_period' => $retention,
                    'disposal_date' => $disposalDate,
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Inventory and ' . $itemCount . ' items saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to save inventory. ' . $e->getMessage());
        }
    }

    public function updateInventory(int $id, array $data): bool
    {
        $inventory = Inventory::findOrFail($id);

        $inventory->update([
            'list_no' => $data['list_no'],
            'series_no' => $data['series_no'],
            'loc_code' => $data['loc_code'],
        ]);

        return true;
    }

    public function getAdminInventories($request)
    {
        if ($request->ajax()) {
            $data = Inventory::whereNotNull('manager_approval');

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
                            <a href="' . route('print-pdf', $row->id) . '" target="_blank">Pdf</a> 
                        </button>
                    ';
                })->addColumn('disposal_date_full', function ($row) {
                    return $row->disposal_date ? Carbon::parse($row->disposal_date)->toDateString() : null;
                })
                ->editColumn('disposal_date', function ($row) {
                    return $row->disposal_date ? Carbon::parse($row->disposal_date)->format('Y') : '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return null;
    }

    public function getManagerInventories($request)
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
                ->editColumn('disposal_date', function ($row) {
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
                })->addColumn('disposal_date_full', function ($row) {
                    return $row->disposal_date ? Carbon::parse($row->disposal_date)->toDateString() : null;
                })
                ->editColumn('disposal_date', function ($row) {
                    return $row->disposal_date ? Carbon::parse($row->disposal_date)->format('Y') : '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return null;
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

    public function deleteInventory(int $id): bool
    {
        $inventory = ArchiveInventories::findOrFail($id);
        return $inventory->delete();
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
