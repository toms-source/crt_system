<?php

namespace App\Http\Controllers;

use app\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    //this function is to create the manager from admin
    public function registerManager(Request $request) {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => ['required', 'confirmed', 'min:8', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*?&]/'],
            'office_id' => 'required|exists:offices,id',
        ]);
    
        // Check if the user with the same name or email already exists
        $existingUser = User::where('email', $request->email)
                            ->orWhere('name', $request->name)
                            ->exists();
    
        if ($existingUser) {
            return redirect()->back()->with('error', 'The name or email is already registered.');
        }
    
        // Create the user
        $manager = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'office_id' => $request->office_id,
        ]);
    
        // Assign role
        $manager->assignRole('manager');
    
        return redirect()->route('admin.manage-accounts')->with('success', 'Cost Center Manager registered successfully!');
    }
    

    public function registerUser(Request $request) {

        //validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|string|max:255|email|unique:users',
            'password' => ['required', 'confirmed', 'min:8', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*?&]/'],
            //'password' => 'required|confirmed|min:8',
        ]);

         // Check if the user with the same name or email already exists
         $existingUser = User::where('email', $request->email)
                            ->orWhere('name', $request->name)
                            ->exists();

        if ($existingUser) {
            return redirect()->back()->with('error', 'The name or email is already registered.');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'managerId' => Auth::user()->id,
            'office_id' => Auth::user()->office_id,
        ]);

        $user->assignRole('user');
        return redirect()->back()->with('success', 'User registered successfully!');
    }
}
