<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function actionLogin(Request $request)
    {
        $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        $check = User::where('username',$request->username)->orWhere('email',$request->username)->first();
        if(!$check){
            return redirect()->back()->withErrors(['username'=>'The credentials doesnt match to our record']);
        }

        if(!Hash::check($request->password,$check->password)){
            return redirect()->back()->withErrors(['username'=>'The credentials doesnt match to our record']);
        }


        auth()->login($check,$request->remember ? true : false);

        return redirect()->route('home');
    }


    public function register()
    {
        return view('auth.register');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
