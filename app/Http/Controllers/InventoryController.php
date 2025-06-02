<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Services\InventoriesService;

class InventoryController extends Controller
{

    protected $inventoriesService;
    public function __construct(InventoriesService $inventoriesService)
    {
        $this->inventoriesService = $inventoriesService;
    }

    public function view()
    {
        return view('user.form');
    }
    public function displayRegister()
    {
        return view('manager.register');
    }

    public function create(Request $request)
    {
        return $this->inventoriesService->createInventory($request);
    }


    public function displayIndexUser()
    {
        $this->inventoriesService->getUserInventories();

        return view('user.index', compact('inventories'));
    }

    // manager approval
    public function approve(Request $request)
    {
        $this->inventoriesService->managerApproval($request);

        return redirect()->route('manager.index')->with('success', 'Inventory approved successfully.');
    }

    // RTO recieve by admin
    public function adminRecieve(Request $request)
    {
        $this->inventoriesService->adminReceive($request);

        return redirect()->route('admin.index')->with('success', 'Inventory recieved successfully.');
    }

    // RTO approve by admin
    public function adminApprove(Request $request)
    {
        $this->inventoriesService->adminApproval($request);

        return redirect()->route('admin.index')->with('success', 'Inventory recieved successfully.');
    }
    // transfer RTO to archives
    public function destroy(Inventory $inventory)
    {
        $this->inventoriesService->toArchiveInventoryAndDelete($inventory);

        return redirect()->back()->with('success', 'Inventory archived successfully.');
    }
}
