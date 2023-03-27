<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Events\RegisterEvent;

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
            return redirect()->back()->withInput()->withErrors(['username'=>'The credentials doesnt match to our record']);
        }

        if(!Hash::check($request->password,$check->password)){
            return redirect()->back()->withInput()->withErrors(['username'=>'The credentials doesnt match to our record']);
        }

        if($check->is_active ==0){
            return redirect()->back()->withInput()->withErrors(['username'=>'This account is non active']);
        }


        auth()->login($check,$request->remember ? true : false);

        return redirect()->route('home');
    }

    public function actionRegister(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'username'=>'required|unique:users,username',
            'email'=>'required|email:dns|unique:users,email',
            'password'=>'required|min:8|same:password_confirmation',
            'terms'=>'required'
        ]);


        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
            'role'=>'seller',
            'is_active'=>0
        ]);

        $user->assignRole('seller');
        event(new RegisterEvent($user));

        return redirect()->route('login')->withErrors(['username'=>'Register Success, waiting admin to active this account']);
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
