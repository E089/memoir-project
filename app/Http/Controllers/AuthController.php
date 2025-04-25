<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 

class AuthController extends Controller
{

    public function showRegister()
        {
            return view('register');  // Ensure you have a 'register.blade.php' view
        }

    public function register(Request $request)
        {
            // Validate the input
            $request->validate([
                'username' => 'required|string|max:255|unique:users,username',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Create the user
            User::create([
                'username' => $request->username,   // Fix: Use $request->username
                'email' => $request->email,         // Fix: Use $request->email
                'password' => bcrypt($request->password),
            ]);
            // Redirect or show a success message
            return redirect()->route('login');
        }

    public function showLogin()
        {
            return view('login'); // Ensure you have a 'login.blade.php' view
        }
    
    public function login(Request $request)
        {
            // Validate input
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);
        
            // Find user by username
            $user = \App\Models\User::where('username', $request->username)->first();
        
            if ($user && Hash::check($request->password, $user->password)) {
                // Log the user in
                Auth::login($user);
        
                // Redirect to home
                return redirect()->route('home');
            } else {
                // Credentials don't match
                return back()->withErrors([
                    'username' => 'These credentials do not match our records.',
                ])->withInput();
            }
        }

        public function logout()
            {
                Auth::logout();  // Log the user out
                
                // Optionally, clear the session
                session()->invalidate();
            
                // Redirect to the 'welcome-page' route
                return redirect()->route('welcome-page');
            }
            
        

}
