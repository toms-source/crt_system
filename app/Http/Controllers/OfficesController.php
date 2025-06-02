<?php

namespace App\Http\Controllers;

use App\Models\Offices;
use Illuminate\Http\Request;
use App\Services\OfficeService;

class OfficesController extends Controller
{
    protected $officeService;
    public function __construct(OfficeService $officeService)
    {
        $this->officeService = $officeService;
    }

    public function storeOffice(Request $request)
    {
        return $this->officeService->newOffice($request);
    }

    public function fetchOfficeSelection()
    {
        $offices = $this->officeService->getAll();

        return view('admin.register', compact('offices'));
    }

    public function displayOffice()
    {
        $offices = $this->officeService->getAll();

        return view('admin.office', compact('offices'));
    }

    public function destroyOffice(Request $request, Offices $office)
    {
        return $this->officeService->deleteOffice($request, $office);
    }

    public function updateOffice(Request $request, Offices $office)
    {
        $result = $this->officeService->updateOffice($request, $office);

        return response()->json($result);
    }
}
