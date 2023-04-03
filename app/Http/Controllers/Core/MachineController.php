<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('module.core.machine.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('module.core.machine.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:machines,name',
            'picture'=>'required|mimes:png,jpg,jpeg,jfif,svg|max:5120',
        ]);

        // upload file
        $picture = $request->file('picture');

        $picture_name = time().$picture->getClientOriginalName();
        $picture->move('uploads/machine',$picture_name);

        Machine::create([
            'name'=>$request->name,
            'picture'=>'uploads/machine/'.$picture_name,
            'created_by'=>auth()->user()->id
        ]);

        return redirect()->route('machine.index')->with(['message'=>'Data created successfully']);
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
    public function edit(Machine $machine)
    {
        $id = $machine->id;
        return view('module.core.machine.form',compact('id','machine'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Machine $machine)
    {
        $required = $machine->picture == null ? 'required|' : '';
        $request->validate([
            'name'=>'required|unique:machines,name,'.$machine->id,
            'picture'=>$required.'mimes:png,jpg,jpeg,jfif,svg|max:5120',
        ]);

        $file_name = $machine->picture;

        if($request->hasFile('picture')){
            // upload file
            $picture = $request->file('picture');

            $picture_name = time().$picture->getClientOriginalName();
            $picture->move('uploads/machine',$picture_name);
            $file_name = 'uploads/machine/'.$picture_name;
        }

        Machine::where('id',$machine->id)->update([
            'name'=>$request->name,
            'picture'=>$file_name
        ]);

        return redirect()->route('machine.index')->with(['message'=>'Data updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Machine $machine)
    {
        $machine->delete();
        return redirect()->route('machine.index')->with(['message'=>'Data deleted successfully']);

    }

    public function json(Request $request)
    {
        $columns = array(
            0 =>'name',
            1 =>'created_by',
        );

        $totalFiltered = Machine::query();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $query = Machine::query();
        $query = $query->with('creator');
        if(!empty($request->input('search.value'))){
            $search = $request->input('search.value');
            $query = $query->where('name', 'like','%'.$search.'%');
            $totalFiltered = $totalFiltered->where('name', 'like','%'.$search.'%');

        }
        $query = $query->offset($start)->limit($limit)->orderBy($order,$dir)->latest()->get();

        $data = array();
        if(!empty($query)){
            foreach ($query as $key=>$value){
            $edit =  route('machine.edit',$value->id);
            $destroy =  route('machine.destroy',$value->id);
            $picture = asset($value->picture);
            $nestedData['no'] = (str_split($start)[0]) * $limit + $key + 1;
            $nestedData['name'] = $value->name;
            $nestedData['picture'] = "<img src='$picture' alt='' class='img-fluid img-thumbnail' />";
            $nestedData['created_by'] = $value->creator->name;
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
            "recordsTotal"    => intval(Machine::count()),
            "recordsFiltered" => intval($totalFiltered->count()),
            "data"            => $data
        );

        return json_encode($json_data);
    }

    public function removeImage(Request $request)
    {
        if($request->filled('id')){
            if(file_exists($request->uri)){
                unlink($request->uri);
                Machine::where('id',$request->id)->update([
                    'picture'=>null
                ]);
                return 'success';
            }
            return 'success';
        }

        return 'no action';
    }
}
