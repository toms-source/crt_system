<?php

namespace App\Services;

use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class UserInventoriesService
{

    public function display()
    {

        $query = Inventory::with(['owner', 'items'])
            ->where('user_id', Auth::id())
            ->get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                $earliestDate = $row->items->min('created_at');
                return $earliestDate ? Carbon::parse($earliestDate)->format('Y-m-d') : '—';
            })
            ->editColumn('disposed_date', function ($row) {
                return $row->disposed_date ? Carbon::parse($row->disposed_date)->format('Y-m-d') : '';
            })
            ->addColumn('manager_approval', fn($row) => ucfirst($row->manager_approval)) // cost center head
            ->addColumn('disposal_status', function ($row) {
                return $row->disposal_status ?? 'N/A';
            })
            ->addColumn('action', function ($row) {
                $downloadUrl = route('print-pdf', $row->id);
                $inventoryJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');

                return '
                    <div class="flex items-center gap-4">
                        <!-- View Button -->
                        <button 
                            x-data 
                            x-on:click=\'$dispatch("open-modal", { inventory: ' . $inventoryJson . ' })\'
                            class="inline-flex items-center px-3 py-1 bg-green-600 text-white text-xs font-semibold rounded hover:bg-green-700 transition">
                            View
                        </button>

                        <!-- Download Button -->
                        <a href="' . $downloadUrl . '" target="_blank" 
                            class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700 transition">
                            Download
                        </a>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function count()
    {
        return Inventory::whereHas('owner', function ($query) {
            $query->where('user_id', Auth::id());
        })->count();
    }
}
