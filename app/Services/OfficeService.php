<?php

namespace App\Services;

use App\Models\Offices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfficeService
{
    /**
     * Get all countries.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    
    public function getAll()
    {
        return Offices::all();
    }

    public function newOffice(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'department' => 'required|string|max:255',
        ]);

        // validation checker
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // checker
        $existingOffice = Offices::where('department', $request->department)->first();
        if ($existingOffice) {
            return redirect()->back()
                ->withErrors(['department' => 'Office already exists.'])
                ->withInput();
        }
        // Create the office
        Offices::create(['department' => $request->department]);

        return redirect()->back()->with('success', 'Office created successfully.');
    }

    public function updateOffice(Request $request, Offices $office)
    {
        // Validation
        $validated = $request->validate([
            'department' => ['required', 'string', 'max:255'],
        ]);

        // Update office
        $office->update([
            'department' => $validated['department'],
        ]);

        return ['success' => true];
    }

    public function deleteOffice(Request $request, Offices $office)
    {
        // Validate password before deleting
        $request->validateWithBag('officeDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Delete the office
        $office->delete();

        return redirect()->route('admin.office')->with('success', 'Department deleted successfully!');
    }
}
