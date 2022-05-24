<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public function create(){
        return view('users.register');
    }
    public function store(Request $request){
        $formFields = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|unique:users',
            'password' => 'min:6|required_with:confirm_password|same:confirm_password',
        ]);
        $formFields['password'] = Hash::make($request->password);
        $user = User::create($formFields);
        auth()->login($user);
        return redirect('/')->with('message','User Created and logged in');
    }

    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message','You have been Logged Out..!');
    }
    public function login(){
        return view('/users.login');
    }
    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email'     => 'required|email',
            'password' => 'required',
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect('/')->with('message','You are Now Logged In..!');
        }

        return back()->withErrors([
            'email' => 'Invalid Credentials'
        ])->onlyInput('email');
    }
}





