<?php

namespace App\Services;

use App\Models\ArchiveInventories;
use App\Models\Inventory;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrintInventoryService
{
    public function generatePdf(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $recieve_date = null;
        $approved_date = null;

        if ($request->has('recieve_date')) {
            $recieve_date = Carbon::createFromFormat('Ymd', $request->recieve_date);
        }

        if ($request->has('approved_date')) {
            $approved_date = Carbon::createFromFormat('Ymd', $request->approved_date);
        }

        $pdf = Pdf::loadView('pdf.inventory-pdf', [
            'inventory' => $inventory,
            'recieve_date' => $recieve_date,
            'approved_date' => $approved_date,
        ])->setPaper('a4', 'landscape');

        return $pdf->download(
            'inventory-' . $inventory->prepared_by . '-' . $inventory->created_at->format('Ymd') . '.pdf'
        );
    }
    public function generateArchPdf(Request $request, $id)
    {
        $inventory = ArchiveInventories::findOrFail($id);

        $recieve_date = null;
        $approved_date = null;

        if ($request->has('recieve_date')) {
            $recieve_date = Carbon::createFromFormat('Ymd', $request->recieve_date);
        }

        if ($request->has('approved_date')) {
            $approved_date = Carbon::createFromFormat('Ymd', $request->approved_date);
        }

        $pdf = Pdf::loadView('pdf.inventory-pdf', [
            'inventory' => $inventory,
            'recieve_date' => $recieve_date,
            'approved_date' => $approved_date,
        ])->setPaper('a4', 'landscape');

        return $pdf->download(
            'inventory-' . $inventory->prepared_by . '-' . $inventory->created_at->format('Ymd') . '.pdf'
        );
    }
}
