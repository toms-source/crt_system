<?php

namespace App\Services;

use App\Models\ArchiveInventories;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminArchInventories
{

    /**
     * Get all countries.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function display()
    {
        $query = ArchiveInventories::with('items', 'office');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('prepared_by', fn($row) => ucfirst($row->prepared_by))
            ->addColumn('manager_approval', fn($row) => ucfirst($row->manager_approval)) // cost center head
            ->addColumn('office_name', function ($row) {
                return $row->office ? $row->office->department : 'N/A';
            })
            ->addColumn('created_at', function ($row) {
                $item = $row->items->first();
                return $item && $item->created_at
                    ? Carbon::parse($item->created_at)->format('Y-m-d')
                    : 'N/A';
            })
            ->addColumn('disposal_status', function ($row) {
                return $row->disposal_status ?? 'N/A';
            })
            ->editColumn('disposed_date', function ($row) {
                return $row->disposed_date ? Carbon::parse($row->disposed_date)->format('Y-m-d') : '';
            })
            ->addColumn('action', function ($row) {
                $deleteUrl = route('archInventory.destroy', $row->id);
                $downloadUrl = route('print-arch-pdf', $row->id);
                $inventoryJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');

                return '
                    <div class="flex items-center gap-4">
                        <!-- View Button -->
                        <button 
                            x-data 
                            x-on:click=\'$dispatch("open-modal", { archInventory: ' . $inventoryJson . ' })\'
                            class="inline-flex items-center px-3 py-1 bg-green-600 text-white text-xs font-semibold rounded hover:bg-green-700 transition">
                            View
                        </button>

                        <!-- Delete Form -->
                        <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Are you sure?\');" class="inline">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit"
                                class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded hover:bg-red-700 transition">
                                Delete
                            </button>
                        </form>

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
}
