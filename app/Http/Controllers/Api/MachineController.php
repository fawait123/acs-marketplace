<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;

class MachineController extends Controller
{
    public function index()
    {
        $machine = Machine::with('assets')->get();
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'data'=>$machine
        ],200);
    }
}
