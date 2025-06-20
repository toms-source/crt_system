<?php

namespace App\Services;

use App\Models\Inventory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ManagerInventoriesService
{
    public function display($request)
    {
        if ($request->ajax()) {
            $data = Inventory::with('user', 'items')
                ->whereHas('user', function ($query) {
                    $query->where('managerId', Auth::id());
                });

            return DataTables::of($data)
                ->addIndexColumn()

                // Prepared By Column
                ->addColumn('prepared_by', function ($row) {
                    return $row->user->name ?? 'N/A';
                })

                // Disposal Date (Year only) — from related inventory items
                ->editColumn('created_at', function ($row) {
                    $earliestDate = $row->items->min('created_at');
                    return $earliestDate ? Carbon::parse($earliestDate)->format('m-d-Y') : '—';
                })

                // Action Buttons
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

                // Mark "action" column as raw HTML
                ->rawColumns(['action'])

                ->make(true);
        }

        return null;
    }
}
