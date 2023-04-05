<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('module.core.customer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('module.core.customer.form');
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
            'email'=>'required|unique:customers,email',
            'username'=>'required|unique:customers,username',
            'password'=>'required|min:8',
            'telp'=>'required',
            'gender'=>'required',
            'ktp'=>'required|mimes:jpg,jpeg,png,svg',
            'picture'=>'required|mimes:jpg,jpeg,png,svg',
        ]);

        if($request->hasFile('ktp')){
            $ktp = $request->file('ktp');
            $ktp_name = time().$ktp->getClientOriginalName();
            $ktp->move('upload/ktp',$ktp_name);
        }

        if($request->hasFile('picture')){
            $picture = $request->file('picture');
            $picture_name = time().$picture->getClientOriginalName();
            $picture->move('upload/ktp',$picture_name);
        }


        Customer::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
            'telp'=>$request->telp,
            'ktp'=>'upload/ktp/'.$ktp_name,
            'picture'=>'upload/ktp/'.$picture_name,
            'is_active'=>1,
            'gender'=>$request->gender
        ]);

        return redirect()->route('customer.index')->with(['message'=>'Date created succesfully']);

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
    public function edit(Customer $customer)
    {
        $id = $customer->id;
        return view('module.core.customer.form',compact('customer','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $rules_password = $request->password ? 'required|min:8':'';
        $rules_picture = $customer->picture ? '' : 'required|';
        $rules_ktp = $customer->ktp ? '' : 'required|';
        $request->validate([
            'name'=>'required',
            'email'=>'required|unique:customers,email,'.$customer->id,
            'username'=>'required|unique:customers,username,'.$customer->id,
            'password'=>$rules_password,
            'telp'=>'required',
            'gender'=>'required',
            'ktp'=>$rules_ktp.'mimes:jpg,jpeg,png,svg',
            'picture'=>$rules_picture.'mimes:jpg,jpeg,png,svg',
        ]);

        $new_password = $request->password ? Hash::make($request->password) : $customer->password;
        $new_picture = $customer->picture;
        $new_ktp = $customer->ktp;
        if($request->hasFile('ktp')){
            $ktp = $request->file('ktp');
            $ktp_name = time().$ktp->getClientOriginalName();
            $ktp->move('upload/ktp',$ktp_name);
            $new_ktp = 'upload/ktp/'.$ktp_name;
        }

        if($request->hasFile('picture')){
            $picture = $request->file('picture');
            $picture_name = time().$picture->getClientOriginalName();
            $picture->move('upload/ktp',$picture_name);
            $new_picture = 'upload/ktp/'.$picture_name;
        }


        Customer::where('id',$customer->id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
            'telp'=>$request->telp,
            'ktp'=>$new_ktp,
            'picture'=>$new_picture,
            'is_active'=>1,
            'gender'=>$request->gender
        ]);

        return redirect()->route('customer.index')->with(['message'=>'Data updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customer.index')->with(['message'=>'Data deleted successfully']);
    }

    public function json(Request $request)
    {
        $columns = array(
            0 =>'name',
            1 =>'gender',
            2=>'email'
        );

        $totalFiltered = Customer::query();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $query = Customer::query();
        // $query = $query->with('creator');
        if(!empty($request->input('search.value'))){
            $search = $request->input('search.value');
            $query = $query->where('name', 'like','%'.$search.'%');
            $totalFiltered = $totalFiltered->where('name', 'like','%'.$search.'%');

        }

        $query = $query->offset($start)->limit($limit)->orderBy($order,$dir)->latest()->get();

        $data = array();
        if(!empty($query)){
            foreach ($query as $key=>$value){
            $edit =  route('customer.edit',$value->id);
            $destroy =  route('customer.destroy',$value->id);
            $status1 = route('customer.status',$value->id);
            $statuses = $value->is_active == 0 ? 'Inactive' : 'Active';
            $status = $value->is_active == 0 ? 'bg-danger' : 'bg-primary';
            $bg = $value->is_active == 0 ? 'primary' : 'danger';
            $icon = $value->is_active == 0 ? 'fa-check' : 'fa-lock';
            $nestedData['no'] = (str_split($start)[0]) * $limit + $key + 1;
            $nestedData['name'] = $value->name;
            $nestedData['email'] = $value->email;
            $nestedData['telp'] = $value->telp;
            $nestedData['gender'] = $value->gender;
            $nestedData['is_active'] = "<span class='badge {$status}'>$statuses</span>";
            $nestedData['options'] = "&emsp;<a href='#' data-toggle='modal'
            data-target='#modal-status' data-uri='{$status1}'
            class='text-{$bg}'><i class='fa {$icon}'></i></a>&emsp;<a href='{$edit}'
            class='text-primary'><i class='fa fa-edit'></i></a>
                                    &emsp;<a href='#' data-toggle='modal'
                                    data-target='#modal-delete' data-url='{$destroy}'
                                    class='text-danger'><i class='fa fa-trash'></i></a>";
            $data[] = $nestedData;
        }
        }


        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval(Customer::count()),
            "recordsFiltered" => intval($totalFiltered->count()),
            "data"            => $data
        );

        return json_encode($json_data);
    }

    public function removeImage(Request $request)
    {
        if($request->type == 'picture'){
            if(file_exists($request->uri)){
                unlink($request->uri);
                Customer::where('id',$request->id)->update([
                    'picture'=>null
                ]);

                return 'success';
            }

            return 'oke';
        }

        if($request->type == 'ktp'){
            if(file_exists($request->uri)){
                unlink($request->uri);
                Customer::where('id',$request->id)->update([
                    'ktp'=>null
                ]);

                return 'success';
            }

            return 'oke';
        }
    }


    public function status(Customer $customer)
    {
        $status = $customer->is_active == 0 ? 1 : 0;
        $customer->update([
            'is_active'=>$status
        ]);

        return redirect()->route('customer.index')->with(['message'=>'Data status updated successfully']);
    }
}
