<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function register(){
        $user['name'] = 'demo admin';
        $user['email'] = 'admin@gmail.com';

        $user['password'] = bcrypt('12345678');
        $user = User::create($user);
        auth()->login($user);
        return redirect()->route('trylogin');
    }

    public function tryLogin(){
        return view('login');
    }

    public function login(Request $request){
        $validatedUser = $request->validate([
            "email"=>["required","email", "exists:users,email"],
            "password"=>["required","string"],
        ]);
        if(auth()->attempt($validatedUser)){
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back()->with("error","Wrong Credentials");
    }

    public function dashboard(){
        return view('dashboard');
    }

    public function logout(Request $request){
        auth()->logout();
        return redirect()->route('trylogin');
    }


}
