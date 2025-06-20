<?php

namespace App\Services;

use App\Models\Inventory; 

class DisposeService
{
    public function disposal($id) 
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->disposal_status = 'disposed';
        $inventory->save();

        return [
            'success' => true,
            'message' => 'Inventory marked as disposed.'
        ];
    }
}