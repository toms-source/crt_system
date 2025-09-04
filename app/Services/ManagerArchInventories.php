<?php

namespace App\Services;

use App\Models\ArchiveInventories;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class ManagerArchInventories
{
    /**
     * Get all countries.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function display()
    {
        $query = ArchiveInventories::with('user', 'items')
            ->whereHas('user', function ($query) {
                $query->where('managerId', Auth::id());
            })
            ->get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('prepared_by', fn($row) => ucfirst($row->prepared_by))
            ->addColumn('manager_approval', fn($row) => ucfirst($row->manager_approval)) // cost center head
            ->addColumn('office_name', function ($row) {
                return $row->office ? $row->office->department : 'N/A';
            })
            ->addColumn('created_at', function ($row) {
                return optional($row->items->first())->disposal_date
                    ? Carbon::parse($row->items->first()->created_at)->format('Y-m-d')
                    : 'N/A';
            })
            
            ->addColumn('disposal_status', function ($row) {
                return $row->disposal_status ?? 'N/A';
            })
            ->editColumn('disposed_date', function ($row) {
                return $row->disposed_date ? Carbon::parse($row->disposed_date)->format('Y-m-d') : '';
            })
            ->addColumn('action', function ($row) {
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
        return ArchiveInventories::whereHas('user', function ($query) {
            $query->where('managerId', Auth::id());
        })->count();
    }
}
