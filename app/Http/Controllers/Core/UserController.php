<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('module.core.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::all();
        return view('module.core.user.form',compact('role'));
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
            'name'=>'required',
            'email'=>'required|email:dns|unique:users,email',
            'username'=>'required|unique:users,username',
            'password'=>'required|min:8',
            'role'=>'required'
        ]);


        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
            'role'=>$request->role,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('user.index')->with(['message'=>'Data created successfully']);
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
        $user = User::with('roles')->find($id);
        $role = Role::all();

        if($user){
            return view('module.core.user.form',compact('id','user','role'));
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
            'name'=>'required',
            'email'=>'required|email:dns|unique:users,email,'.$id,
            'username'=>'required|unique:users,username,'.$id,
            'role'=>'required'
        ]);
        $user = User::find($id);
        $password = $user->password;
        if(!is_null($request->password)){
            $password = Hash::make($request->password);
        }

        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'username'=>$request->username,
            'password'=>$password,
            'role'=>$request->role,
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('user.index')->with(['message'=>'Data updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user){
            $user->delete();

            return redirect()->route('user.index')->with(['message'=>'Data deleted successfully']);
        }

        return abort(404);
    }


    public function json(Request $request)
    {
        $columns = array(
            0 =>'name',
            0 =>'username',
            1 =>'email',
            2=> 'role',
        );

        $totalFiltered = User::query();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $query = User::query();
        if(!empty($request->input('search.value'))){
            $search = $request->input('search.value');
            $query = $query->where('name', 'like','%'.$search.'%');
            $totalFiltered = $totalFiltered->where('name', 'like','%'.$search.'%');

        }
        $query = $query->offset($start)->limit($limit)->orderBy($order,$dir)->latest()->get();

        $data = array();
        if(!empty($query)){
            foreach ($query as $key=>$value){
            $edit =  route('user.edit',$value->id);
            $destroy =  route('user.destroy',$value->id);
            $nestedData['no'] = (str_split($start)[0]) * $limit + $key + 1;
            $nestedData['name'] = $value->name;
            $nestedData['username'] = $value->username;
            $nestedData['role'] = $value->role;
            $nestedData['email'] = $value->email;
            if($value->role != 'superadmin'){
                $nestedData['options'] = "&emsp;<a href='{$edit}'
                class='text-primary'><i class='fa fa-edit'></i></a>
                                        &emsp;<a href='#' data-toggle='modal'
                                        data-target='#modal-delete' data-url='{$destroy}'
                                        class='text-danger'><i class='fa fa-trash'></i></a>";
            }else{
                $nestedData['options'] = '<span class="badge bg-danger text-white">No Action</span>';

            }
            $data[] = $nestedData;
            }
        }


        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval(User::count()),
            "recordsFiltered" => intval($totalFiltered->count()),
            "data"            => $data
        );

        return json_encode($json_data);
    }
}
