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
            return view('register'); 
        }

    public function register(Request $request)
        {
            $request->validate([
                'username' => 'required|string|max:20|unique:users,username',
                'email' => 'required|email|max:50|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ]);

            User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return redirect()->route('login');
        }

    public function showLogin()
        {
            return view('login'); 
        }
    
    public function login(Request $request)
        {
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);
        
            $user = \App\Models\User::where('username', $request->username)->first();
        
            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);
        
                return redirect()->route('home');
            } else {
                return back()->withErrors([
                    'username' => 'These credentials do not match our records.',
                ])->withInput();
            }
        }

        public function logout()
            {
                Auth::logout();  
                
                session()->invalidate();
            
                return redirect()->route('welcome-page');
            }
            
        

}
