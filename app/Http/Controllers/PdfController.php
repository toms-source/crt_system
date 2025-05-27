<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    //
    public function print($id)
    {
        $inventory = Inventory::findOrFail($id);

        $pdf = Pdf::loadView('pdf.inventory-pdf', compact('inventory'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('inventory-' . $inventory->prepared_by . '-' . $inventory->created_at->format('Ymd') . '.pdf');
    }
}
