<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Market;

class MarketController extends Controller
{
    public function index()
    {
        return view('module.core.market.index');
    }

    public function json(Request $request)
    {
        $columns = array(
            0 =>'name',
            1 =>'address',
            2=>'telp'
        );

        $totalFiltered = Market::query();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $query = Market::query();
        $query = $query->with('owner');
        if(!empty($request->input('search.value'))){
            $search = $request->input('search.value');
            $query = $query->where('name', 'like','%'.$search.'%');
            $totalFiltered = $totalFiltered->where('name', 'like','%'.$search.'%');

        }
        $query = $query->offset($start)->limit($limit)->orderBy($order,$dir)->latest()->get();

        $data = array();
        if(!empty($query)){
            foreach ($query as $key=>$value){
            $route = route('core.market.status',$value->id);
            $show = route('core.market.show',$value->id);
            $permission = route('role.permission',$value->id);
            $nestedData['no'] = (str_split($start)[0]) * $limit + $key + 1;
            $nestedData['name'] = $value->name;
            $nestedData['address'] = $value->address;
            $nestedData['telp'] = $value->telp;
            $nestedData['status'] = $value->status == 0 ? '<span class="badge bg-danger text-white">Inactive</span>' : '<span class="badge bg-primary text-white">Active</span>';
            $nestedData['owner'] = $value->owner->name;
            if($value->status == 0){
                $nestedData['options'] = "&emsp;<a href='#' class='btn btn-primary btn-sm' data-toggle='modal' data-uri='$route' data-target='#modal-status' class='text-primary'><i class='fa fa-toggle-on'></i></a>";
                $nestedData['options'] .= "&emsp;<a href='$show' class='btn btn-default btn-sm' class='text-primary'><i class='fa fa-eye'></i></a>";
            }else{
                $nestedData['options'] = "&emsp;<a href='#' class='btn btn-danger btn-sm' data-toggle='modal' data-uri='$route' data-target='#modal-status' class='text-primary'><i class='fa fa-toggle-off'></i></a>";
                $nestedData['options'] .= "&emsp;<a href='$show' class='btn btn-default btn-sm' class='text-primary'><i class='fa fa-eye'></i></a>";
            }
            $data[] = $nestedData;
        }
    }


        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval(Market::count()),
            "recordsFiltered" => intval($totalFiltered->count()),
            "data"            => $data
        );

        return json_encode($json_data);
    }

    public function status(Market $market)
    {
        $status = $market->status == 0 ? 1 : 0;
        Market::where('id',$market->id)->update([
            'status'=>$status
        ]);


        return redirect()->back()->with(['message'=>'Update status market successfully']);
    }

    public function show(Market $market)
    {
        return view('market',compact('market'));
    }
}
