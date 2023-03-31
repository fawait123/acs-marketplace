<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Machine;
use App\Models\Asset;
use App\Models\DetailAsset;
use App\Models\Market;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('module.market.asset.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = Type::all();
        $machine = Machine::all();
        return view('module.market.asset.form',compact('type','machine'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name'=>'required',
            'machine_id'=>'required',
            'type_id'=>'required',
            'color'=>'required',
            'km'=>'required',
            'year'=>'required|numeric',
            'stok'=>'required|numeric',
            'price'=>'required',
            'description'=>'required',
            'picture'=>'required|mimes:png,jpg,jpeg,jfif,svg|max:5120',
            'asset.*'=>'mimes:png,jpg,jpeg,jfif,svg|max:5120',
        ];

        $request->validate($rules);

        // upload file
        $picture = $request->file('picture');

        $picture_name = time().$picture->getClientOriginalName();
        $picture->move('uploads/asset',$picture_name);

        // find market id
        $market = Market::where('owner_id',auth()->user()->id)->first();

        $asset = Asset::create([
            'name'=>$request->name,
            'color'=>$request->color,
            'year'=>$request->year,
            'price'=>join('',explode(',',$request->price)),
            'km'=>$request->km,
            'stok'=>$request->stok,
            'description'=>$request->description,
            'machine_id'=>$request->machine_id,
            'type_id'=>$request->type_id,
            'market_id'=>$market->id,
            'picture'=>'uploads/asset/'.$picture_name,
        ]);

        // jika ada file tambahan
        if($request->hasFile('asset')){
            $assetFile = $request->file('asset');
            for ($i=0; $i < count($assetFile); $i++) {
                $asset_name = time().$assetFile[$i]->getClientOriginalName();
                $assetFile[$i]->move('uploads/asset',$asset_name);

                DetailAsset::create([
                    'picture'=>'uploads/asset/'.$asset_name,
                    'asset_id'=>$asset->id
                ]);
            }
        }

        return redirect()->route('asset.index')->with(['message'=>'Data created successfully']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        $id = $asset->id;
        $type = Type::all();
        $machine = Machine::all();
        return view('module.market.asset.form',compact('asset','id','type','machine'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asset $asset)
    {
        $picture = $asset->picture == null ? 'required|' : '';
        $rules = [
            'name'=>'required',
            'machine_id'=>'required',
            'type_id'=>'required',
            'color'=>'required',
            'km'=>'required',
            'year'=>'required|numeric',
            'stok'=>'required|numeric',
            'price'=>'required',
            'description'=>'required',
            'picture'=>$picture.'mimes:png,jpg,jpeg,jfif,svg|max:5120',
            'asset.*'=>'mimes:png,jpg,jpeg,jfif,svg|max:5120',
        ];

        $request->validate($rules);

        // find market id
        $market = Market::where('owner_id',auth()->user()->id)->first();

        $picture_name = $asset->picture;

        if($request->hasFile('picture')){
            $filePicture = $request->file('picture');
            $picture_name = time().$filePicture->getClientOriginalName();
            $filePicture->move('uploads/asset',$picture_name);
        }

        $asset->update([
            'name'=>$request->name,
            'color'=>$request->color,
            'year'=>$request->year,
            'price'=>join('',explode(',',$request->price)),
            'km'=>$request->km,
            'stok'=>$request->stok,
            'description'=>$request->description,
            'machine_id'=>$request->machine_id,
            'type_id'=>$request->type_id,
            'market_id'=>$market->id,
            'picture'=>'uploads/asset/'.$picture_name,
        ]);

        // jika ada file tambahan
        if($request->hasFile('asset')){
            $assetFile = $request->file('asset');
            for ($i=0; $i < count($assetFile); $i++) {
                $asset_name = time().$assetFile[$i]->getClientOriginalName();
                $assetFile[$i]->move('uploads/asset',$asset_name);

                DetailAsset::create([
                    'picture'=>'uploads/asset/'.$asset_name,
                    'asset_id'=>$asset->id
                ]);
            }
        }

        return redirect()->route('asset.index')->with(['message'=>'Data updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        DetailAsset::where('asset_id',$asset->id)->delete();
        return redirect()->route('asset.index')->with(['message'=>'Data deleted successfully']);
    }

    public function json(Request $request)
    {
        $columns = array(
            0 =>'name',
            1 =>'display_name',
            2=>'display_name'
        );

        $totalFiltered = Asset::query();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $query = Asset::query();
        $query = $query->with(['details','type','machine']);
        if(!empty($request->input('search.value'))){
            $search = $request->input('search.value');
            $query = $query->where('name', 'like','%'.$search.'%');
            $totalFiltered = $totalFiltered->where('name', 'like','%'.$search.'%');

        }
        $query = $query->offset($start)->limit($limit)->orderBy($order,$dir)->latest()->get();

        $data = array();
        if(!empty($query)){
            foreach ($query as $key=>$value){
            $edit =  route('asset.edit',$value->id);
            $destroy =  route('asset.destroy',$value->id);
            $color = $value->color;
            $nestedData['no'] = (str_split($start)[0]) * $limit + $key + 1;
            $nestedData['name'] = $value->name;
            $nestedData['color'] = "<div class='card-color' style='background: $color'></div>";
            $nestedData['price'] = number_format($value->price,2,',','.');
            $nestedData['type'] = $value->type->name;
            $nestedData['machine'] = $value->machine->name;
            $nestedData['year'] = $value->year;
            $nestedData['options'] = "&emsp;<a href='{$edit}'
            class='text-primary'><i class='fa fa-edit'></i></a>
                                    &emsp;<a href='#' data-toggle='modal'
                                    data-target='#modal-delete' data-url='{$destroy}'
                                    class='text-danger'><i class='fa fa-trash'></i></a>";
            $data[] = $nestedData;
        }
        }


        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval(Asset::count()),
            "recordsFiltered" => intval($totalFiltered->count()),
            "data"            => $data
        );

        return json_encode($json_data);
    }

    public function removeImage(Request $request)
    {
        if($request->filled('id')){
            if($request->source == 'Asset'){
                unlink($request->uri);
                Asset::where('id',$request->id)->update([
                    'picture'=>null
                ]);

                return 'success';
            }else{
                unlink($request->uri);
                DetailAsset::where('id',$request->id)->delete();

                return 'success';
            }
        }

        return 'no action';
    }
}
