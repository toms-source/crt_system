<?php

namespace App\Services;

use App\Models\Inventory;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class AdminInventoriesService
{
    public function display($request)
    {
        if ($request->ajax()) {
            $data = Inventory::with('items')->whereNotNull('manager_approval');

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

                            <button 
                                x-data 
                                x-on:click="$dispatch(\'confirm-dispose\', { id: ' . $row->id . ' })"
                                class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded hover:bg-red-600 transition"
                            >
                                Dispose
                            </button>

                            <a href="' . route('print-pdf', $row->id) . '" target="_blank" class=" ml-3">
                                <button class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded hover:bg-red-700 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                        <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                                        <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                                    </svg>
                                    Download 
                                </button>
                            </a>
    ';
                })->addColumn('disposal_date_full', function ($row) {
                    return $row->disposal_date ? Carbon::parse($row->disposal_date)->toDateString() : null;
                })->editColumn('created_at', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->format('m/d/Y') : '';
                })
                ->editColumn('disposal_date', function ($row) {
                    return $row->disposal_date ? Carbon::parse($row->disposal_date)->format('Y') : '';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return null;
    }
}
