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

    public function update(Request $request, int $id, InventoriesService $inventoriesService)
    {
        $validated = $request->validate([
            'list_no' => 'required|string|max:50',
            'series_no' => 'required|string|max:50',
            'loc_code' => 'required|string|max:50',
        ]);

        $inventoriesService->updateInventory($id, $validated);

        return response()->json(['message' => 'Inventory updated successfully.']);
    }

    public function displayIndexUser()
    {
        $inventories = $this->inventoriesService->getUserInventories();
        $totalInv = $inventories->count();
        return view('user.index', compact('inventories', 'totalInv'));
    }

    // index display of admin
    public function adminDisplay(Request $request)
    {
        $data = $this->inventoriesService->getAdminInventories($request);
        if ($data) return $data;

        return view('admin.index');
    }

    // index display of manager
    public function managerDisplay(Request $request)
    {
        $data = $this->inventoriesService->getManagerInventories($request);
        if ($data) return $data;

        return view('manager.index');
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

    // archive inventory
    public function destroyArch($id)
    {
        $this->inventoriesService->deleteInventory($id);

        return redirect()->back()->with('success', 'Inventory archived successfully.');
    }
}
