<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;
use App\Models\Type;
use App\Models\Asset;
use App\Models\Notification;
use App\Helpers\Pagination;

class ResourceController extends Controller
{

    public function categories(Request $request)
    {
            try{
                $categories = Machine::latest()->get();
                return response()->json([
                    'code'=>200,
                    'status'=>'List Categories',
                    'data'=>[
                        'results'=>$categories
                    ]
                ]);
            }catch(Exception $error){
                return response()->json([
                    'status'=>500,
                    'message'=>$error->getMessage(),
                    'data'=>[]
                ]);
            }
    }

    public function types()
    {
        try{
            $types = Type::latest()->get();
            return response()->json([
                'code'=>200,
                'status'=>'List type',
                'data'=>[
                    'results'=>$types
                ]
            ]);
        }catch(Exception $error){
            return response()->json([
                'status'=>500,
                'message'=>$error->getMessage(),
                'data'=>[]
            ]);
        }
    }

    public function products(Request $request)
    {
        try{
            $meta = Pagination::defaultMetaInput($request->only(['page','perPage','order','dir','search']));
            $query = Asset::query();
            $query = $query->with(['details','type','machine','market']);

            if($meta['search'] != ''){
                $query = $query->where('name','like','%'. $meta['search'].'%')->orWhere('body','like','%'. $meta['search'].'%');
            }

            if($request->filled('machine_id')){
                $query = $query->where('machine_id',$request->machine_id);
            }

            if($request->filled('id')){
                $query = $query->where('id',$request->id);
            }

            $total = $query->count();
            $meta = Pagination::additionalMeta($meta, $total);
            if ($meta['perPage'] != '-1') {
                $query->offset($meta['offset'])->limit($meta['perPage']);
            }
            $results = $query->get();
            $data = [
                'results'  => $results,
                'meta'     =>  $meta
            ];
            return response()->json([
                'status'=>200,
                'message'=>'List Products',
                'data'=>$data
            ]);
        }catch(Exception $error){
            return response([
                'status'=>500,
                'message'=>$error->getMessage(),
                'data'=>[]
            ]);
        }
    }


    public function notifications(Request $request)
    {
        try{
            $meta = Pagination::defaultMetaInput($request->only(['page','perPage','order','dir','search']));
            $query = Notification::query();
            $query = $query->with(['type','machine','market']);

            if($meta['search'] != ''){
                $query = $query->where('name','like','%'. $meta['search'].'%');
            }

            if($request->filled('category_id')){
                $query = $query->where('machine_id',$request->category_id);
            }

            if($request->filled('id')){
                $query = $query->where('id',$request->id);
            }

            if($request->filled('type_id')){
                $query = $query->where('type_id',$request->type_id);
            }

            $total = $query->count();
            $meta = Pagination::additionalMeta($meta, $total);
            if ($meta['perPage'] != '-1') {
                $query->offset($meta['offset'])->limit($meta['perPage']);
            }
            $results = $query->get();
            $data = [
                'results'  => $results,
                'meta'     =>  $meta
            ];
            return response()->json([
                'status'=>200,
                'message'=>'List notifications',
                'data'=>$data
            ]);
        }catch(Exception $error){
            return response()->json([
                'status'=>500,
                'message'=>$error->getMessage(),
                'data'=>[]
            ]);
        }
    }
}
