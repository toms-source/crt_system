<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

class DTController extends Controller
{
    //
    public function display(Request $request)
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
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('manager.index');
    }

}
