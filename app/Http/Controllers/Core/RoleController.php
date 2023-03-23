<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('module.core.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('module.core.role.form');
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
            'name'=>'required|unique:roles,name',
            'display_name'=>'required'
        ]);

        Role::create([
            'name'=>$request->name,
            'display_name'=>$request->display_name
        ]);

        return redirect()->route('role.index')->with(['message'=>'Data created successfully']);
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
    public function edit($id)
    {
        $role = Role::find($id);
        if($role){
            return view('module.core.role.form',compact('id','role'));
        }

        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|unique:roles,name,'.$id,
            'display_name'=>'required'
        ]);

        $role = Role::find($id);

        $role->update([
            'name'=>$request->name,
            'display_name'=>$request->display_name
        ]);

        return redirect()->route('role.index')->with(['message'=>'Data updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('role.index')->with(['message'=>'Data deleted successfully']);
    }

    public function permission($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        $permission = $role->permissions;
        return view('module.core.role.permission',compact('role','permissions','permission'));
    }

    public function permissionSync(Request $request)
    {
        $role = Role::where('name',$request->role)->first();

        $role->syncPermissions($request->permission);
        return 'success';
    }

    public function json(Request $request)
    {
        $columns = array(
            0 =>'name',
            1 =>'display_name',
            2=>'display_name'
        );

        $totalFiltered = Role::query();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $query = Role::query();
        if(!empty($request->input('search.value'))){
            $search = $request->input('search.value');
            $query = $query->where('name', 'like','%'.$search.'%');
            $totalFiltered = $totalFiltered->where('name', 'like','%'.$search.'%');

        }
        $query = $query->offset($start)->limit($limit)->orderBy($order,$dir)->latest()->get();

        $data = array();
        if(!empty($query)){
            foreach ($query as $key=>$value){
            $edit =  route('role.edit',$value->id);
            $destroy =  route('role.destroy',$value->id);
            $permission = route('role.permission',$value->id);
            $nestedData['no'] = (str_split($start)[0]) * $limit + $key + 1;
            $nestedData['name'] = $value->name;
            $nestedData['display_name'] = $value->display_name;
            if($value->name != 'superadmin'){
                $nestedData['options'] = "<a href='{$permission}' class='text-warning'><i class='fa fa-key'></i></a>";
                $nestedData['options'] .= "&emsp;<a href='{$edit}'
                class='text-primary'><i class='fa fa-edit'></i></a>
                                        &emsp;<a href='#' data-toggle='modal'
                                        data-target='#modal-delete' data-url='{$destroy}'
                                        class='text-danger'><i class='fa fa-trash'></i></a>";
            }else{
                $nestedData['options'] = "<a href='{$permission}' class='text-warning'><i class='fa fa-key'></i></a>&nbsp;&nbsp;";
                $nestedData['options'] .= '<span class="badge bg-danger text-white">No Action</span>';
            }
            $data[] = $nestedData;
            }
        }


        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval(Role::count()),
            "recordsFiltered" => intval($totalFiltered->count()),
            "data"            => $data
        );

        return json_encode($json_data);
    }
}
