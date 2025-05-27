<?php

namespace App\Http\Controllers;

use App\Models\Offices;
use Illuminate\Http\Request;

class OfficesController extends Controller
{
    //
    public function storeOffice(Request $request)
    {
        $request->validate([
            'department' => 'required|string|max:255',
        ]);

        $existingOffice = Offices::where('department', $request->department)->first();

        if ($existingOffice) {
            return back()->withErrors(['name' => 'Office already exists.'])->withInput();
        }

        Offices::create(['department' => $request->department]);

        return redirect()->back()->with('success', 'Office created successfully.');
    }

    public function fetchSelection()
    {
        $offices = Offices::all();

        return view('admin.register', compact('offices'));
    }

    public function display()
    {
        $offices = Offices::all();

        return view('admin.office', compact('offices'));
    }

    public function destroy(Request $request, Offices $office)
    {
        // Validate the password before deleting
        $request->validateWithBag('officeDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $office->delete();

        return redirect()->route('admin.office')->with('success', 'department deleted successfully!');
    }

    public function update(Request $request, Offices $office)
    {
        $request->validate([
            'department' => ['required', 'string', 'max:255'],
        ]);

        $office->update([
            'department' => $request->department,
        ]);

        return response()->json(['success' => true]);
    }
}
