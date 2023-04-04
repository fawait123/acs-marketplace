<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Machine;

class WelcomeController extends Controller
{
    public function index()
    {
        $assets = Asset::latest()->take(8)->get();
        $assetsOld = Asset::where('year','<',2015)->take(8)->get();
        $assetRandom = Asset::inRandomOrder()->take(9)->get();
        $machines = Machine::all();
        return view('frontend.welcome',compact('assets','assetsOld','assetRandom','machines'));
    }

    public function products()
    {
        $products = Asset::latest()->get();
        $assetRandom = Asset::inRandomOrder()->take(9)->get();
        return view('frontend.produts',compact('products','assetRandom'));
    }

    public function product($id)
    {
        $product = Asset::with(['details','type','machine','market'])->find($id);
        if($product){
            $assetRandom = Asset::inRandomOrder()->take(9)->get();
            return view('frontend.product',compact('assetRandom','product'));
        }

        return abort(404);
    }

    public function categories($category)
    {
        $products = Asset::whereHas('machine',function($qr)use($category){
            $qr->where('name',$category);
        })->get();
        return view('frontend.categories',compact('products'));
    }
}
