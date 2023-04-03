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
        return view('welcome',compact('assets','assetsOld','assetRandom','machines'));
    }
}
