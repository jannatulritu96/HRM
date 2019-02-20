<?php

namespace App\Http\Controllers;

use App\Attendence;
use App\Exports\AttendenceExport;
use App\Imports\AttendenceImport;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AttendenceController extends Controller
{
    public function index(Request $request)
    {
        $data['title']='List of Attendence';
        $render=[];
        $attendence = new Attendence();
        $attendence= $attendence->with('relUser');
        if(isset($request->date))
        {
            $attendence=$attendence->where('date',$request->date);
            $render['date']=$request->date;
        }
        if(isset($request->status))
        {
            $attendence=$attendence->where('status',$request->status);
            $render['status']=$request->status;
        }
        $attendence= $attendence->orderBy('id','DESC');
        $attendence= $attendence->paginate(10);
        $attendence= $attendence->appends($render);
        $data['attendences']=$attendence;
        return view('admin.attendence.index',$data);
    }
    public function create()
    {
        $data['title']='Upload Attendence sheet';
        return view('admin.attendence.create',$data);
    }
    public function store(Request $request)
    {
        Excel::import(new AttendenceImport, $request->file('attendence_file'));

        session()->flash('success','Attendence uploaded successfully');
        return redirect()->route('attendence.index');
    }
    public function show(Request $request,$user_id,$export=false)
    {
        $user= User::findOrFail($user_id);
        $data['title']='Attendence of '.$user->name;
        $render=[];
        $attendence = new Attendence();
        $attendence= $attendence->with('relUser');
        $attendence=$attendence->where('user_id',$user_id);

        if(isset($request->start_date) && isset($request->end_date))
        {
            $attendence=$attendence->whereBetween('date',[$request->start_date,$request->end_date]);
            $render['start_date']=$request->start_date;
            $render['end_date']=$request->end_date;
        }elseif(isset($request->start_date))
        {
            $attendence=$attendence->where('date',$request->start_date);
            $render['start_date']=$request->start_date;
        }
        if(isset($request->status))
        {
            $attendence=$attendence->where('status',$request->status);
            $render['status']=$request->status;
        }
        if(!empty($export))
        {
            return Excel::download(new AttendenceExport($user_id), $user->name.'.xlsx');
        }
        $attendence= $attendence->orderBy('id','DESC');
        $attendence= $attendence->paginate(10);
        $attendence= $attendence->appends($render);
        $data['attendences']=$attendence;
        $data['user']=$user;
        return view('admin.attendence.show',$data);
    }
}
