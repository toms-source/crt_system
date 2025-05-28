<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    //
    public function print(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        // Optional: Validate dates if needed
        if ($request->has('recieve_date')) {
            $recieve_date = Carbon::createFromFormat('Ymd', $request->recieve_date);
        }

        if ($request->has('approved_date')) {
            $approved_date = Carbon::createFromFormat('Ymd', $request->approved_date);
        }

        // Pass any extra data you want to the PDF view
        $pdf = Pdf::loadView('pdf.inventory-pdf', [
            'inventory' => $inventory,
            'recieve_date' => $recieve_date ?? null,
            'approved_date' => $approved_date ?? null,
        ])->setPaper('a4', 'landscape');

        return $pdf->download(
            'inventory-' . $inventory->prepared_by . '-' . $inventory->created_at->format('Ymd') . '.pdf'
        );
    }
}
