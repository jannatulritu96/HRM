<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Department;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     $data['title'] = 'User List';
        $users= new User();
        $users= $users->with(['relDepartment','relDesignation']);
        $render=[];
        if(isset($request->name))
        {
            $users=$users->where('name','like','%'.$request->name.'%');
            $render['name']=$request->name;
        }
        if(isset($request->email))
        {
            $users=$users->where('email','like','%'.$request->email.'%');
            $render['email']=$request->email;
        }
        if(isset($request->type))
        {
            $users=$users->where('type','like','%'.$request->type.'%');
            $render['type']=$request->type;
        }
        if(isset($request->status))
        {
            $users=$users->where('status',$request->status);
            $render['status']=$request->status;
        }
        $users= $users->paginate(10);
        $users= $users->appends($render);
        $data['users'] = $users;
        return view('admin.user.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Create User';
        $data['departments'] = Department::where('status','Active')->pluck('name','id');
        $data['designations'] = [];
        return view('admin.user.create',$data);
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
            'status' => 'required',
            'department_id' => 'required'
        ]);
        $user = new User();
        $user->name= $request->name;
        $user->status= $request->status;
        $user->department_id=$request->department_id;
        $user->save();
        session()->flash('success','User stored successfully');
        return redirect()->route('user.index');    }

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
