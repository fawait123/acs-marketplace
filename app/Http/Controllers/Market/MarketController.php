<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\Market;
use App\Models\User;

class MarketController extends Controller
{
    public function index()
    {
        $market = Market::with(['assets.details','assets.machine','assets.type'])->find(auth()->user()->id);
        return view('module.market.market.index',compact('market'));
    }

    public function register()
    {
        $market = Market::with('owner')->find(auth()->user()->profile_id);
        return view('market',compact('market'));
    }

    public function actionRegister(Request $request)
    {
        $request->validate([
            "market_name" => "required|unique:markets,name",
            "market_telp" => "required|unique:markets,telp",
            "market_address" => "required",
            "market_picture" => "required|mimes:jpg,jpeg,jfif,png",
            "nik" => "required|unique:owners,name",
            "name" => "required",
            "address" => "required",
            "gender" => "required",
            "email" => "required|email:dns|unique:owners,email",
            "telp" => "required|unique:owners,telp",
            "picture" => "required|mimes:jpg,jpeg,jfif,png",
            "ktp" => "required|mimes:jpg,jpeg,jfif,png",
        ]);

        if($request->file('picture')){
            $picture = $request->file('picture');
            $picture_name = time().$picture->getClientOriginalName();
            $picture->move('upload/identity',$picture_name);
        }

        if($request->file('ktp')){
            $ktp = $request->file('ktp');
            $ktp_name = time().$ktp->getClientOriginalName();
            $ktp->move('upload/identity',$ktp_name);
        }

        if($request->file('market_picture')){
            $market_picture = $request->file('market_picture');
            $market_picture_name = time().$market_picture->getClientOriginalName();
            $market_picture->move('upload/market',$market_picture_name);
        }


        $owner = Owner::create([
            "nik"=>$request->nik,
            "name"=>$request->name,
            "address"=>$request->address,
            "gender"=>$request->gender,
            "email"=>$request->email,
            "telp"=>$request->telp,
            "picture"=>'upload/identity/'.$picture_name ?? '',
            "ktp"=>'upload/identity/'.$ktp_name ?? ''
        ]);


        $market = Market::create([
            "owner_id"=>$owner->id,
            "name"=>$request->market_name,
            "telp"=>$request->market_telp,
            "address"=>$request->market_address,
            "picture"=>'upload/market/'.$market_picture_name ?? '',
        ]);

        User::where('id',auth()->user()->id)->update([
            'profile_id'=>$market->id
        ]);

        return redirect()->back()->with(['message'=>'Market register successfully']);


    }
}
