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
        return ArchiveInventories::with('items')->paginate(5);
    }
    public function getAll()
    {
        $user = Auth::user();

        return ArchiveInventories::with('owner', 'items')
            ->where('office_id', $user->office_id)
            ->get();
    }
    
}
