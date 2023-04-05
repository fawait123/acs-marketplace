<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    public function login()
    {
        return view('frontend.login');
    }


    public function register()
    {
        return view('frontend.register');
    }

    public function actionRegister(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|unique:customers,email',
            'username'=>'required|unique:customers,username',
            'password'=>'required|min:8',
            'telp'=>'required',
            'gender'=>'required',
            'ktp'=>'required|mimes:jpg,jpeg,png,svg',
            'picture'=>'required|mimes:jpg,jpeg,png,svg',
        ]);

        if($request->hasFile('ktp')){
            $ktp = $request->file('ktp');
            $ktp_name = time().$ktp->getClientOriginalName();
            $ktp->move('upload/ktp',$ktp_name);
        }

        if($request->hasFile('picture')){
            $picture = $request->file('picture');
            $picture_name = time().$picture->getClientOriginalName();
            $picture->move('upload/ktp',$picture_name);
        }


        Customer::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
            'telp'=>$request->telp,
            'ktp'=>'upload/ktp/'.$ktp_name,
            'picture'=>'upload/ktp/'.$picture_name,
            'is_active'=>0,
            'gender'=>$request->gender
        ]);

        return redirect()->route('customer.auth.login')->withErrors(['username'=>'Register successfully']);
    }

    public function actionLogin(Request $request)
    {
        $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        $check = Customer::where('username',$request->username)->orWhere('email',$request->username)->first();
        if(!$check){
            return redirect()->back()->withInput()->withErrors(['username'=>'The credentials doesnt match to our record']);
        }

        if(!Hash::check($request->password,$check->password)){
            return redirect()->back()->withInput()->withErrors(['username'=>'The credentials doesnt match to our record']);
        }

        if($check->is_active ==0){
            return redirect()->back()->withInput()->withErrors(['username'=>'This account is non active']);
        }


        auth('customer')->login($check,$request->remember ? true : false);

        return redirect()->route('welcome');
    }
}
