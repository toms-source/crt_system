<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function display()
    {
        $users = User::whereHas("roles", function ($query) {
            $query->whereIn("name", ["manager", "user"]);
        })->paginate(6);

        //for API Testin only
        // return response()->json($users);
        return view('admin.manage-accounts', compact('users'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->paginate(6);

        if ($search == null) {
            return redirect()->route('admin.manage-accounts');
        }

        return view('admin.manage-accounts', compact('users', 'search'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function destroy(Request $request, User $user)
    {
        // Validate the password before deleting
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user->delete();

        return redirect()->route('admin.manage-accounts')->with('success', 'User deleted successfully!');
    }
}
