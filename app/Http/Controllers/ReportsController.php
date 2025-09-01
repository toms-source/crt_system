<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ArchiveInventories;
use App\Models\Offices;
use App\Services\InventoriesArchService;
use App\Services\AdminArchInventories;

class ReportsController extends Controller
{
    protected $inventoriesArchService;
    protected $adminArchiveInventory;

    public function __construct(InventoriesArchService $inventoriesArchService, AdminArchInventories $adminArchiveInventory)
    {
        // Inventories constructor
        $this->inventoriesArchService = $inventoriesArchService;
        $this->adminArchiveInventory = $adminArchiveInventory;
    }

    //the function where the archive inventory fetches and display in admin reports
    public function adminReports()
    {

        if (request()->ajax()) {
            return $this->adminArchiveInventory->display();
        }
        // This count all the user's table
        // archive inventories table and office table
        $users = User::count() - 1;
        $inventories = ArchiveInventories::count();
        $office = Offices::count();

        

        return view('admin.reports', compact('users', 'inventories', 'office'));
    }

    // the function where the archive inventory fetches and display in managers reports
    public function managerReports()
    {
        $managerArchiveInventory = $this->inventoriesArchService->ccmArchive();
        $totalInv = $managerArchiveInventory->count();
        return view('manager.reports', compact('managerArchiveInventory', 'totalInv'));
    }

    public function userReports()
    {
        $userArchiveInventory = $this->inventoriesArchService->getAll();
        $totalArch = $userArchiveInventory->count();
        return view('user.reports', compact('userArchiveInventory', 'totalArch'));
    }
}
