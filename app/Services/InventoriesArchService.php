<?php

namespace App\Services;

use App\Models\ArchiveInventories;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InventoriesArchService
{

    /**
     * Get all countries.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function getAllByAdmin()
    {
        $data = ArchiveInventories::paginate(5);

        $data->getCollection()->transform(function ($item) {
            $item->disposal_date = Carbon::parse($item->disposal_date)->format('Y');
            return $item;
        });

        return $data;
    }
    public function getAll()
    {
        $user = Auth::user();

        return ArchiveInventories::with('owner')
            ->where('office_id', $user->office_id)
            ->get()
            ->map(function ($item) {
                $item->disposal_date = \Carbon\Carbon::parse($item->disposal_date)->format('Y');
                return $item;
            });
    }
}
