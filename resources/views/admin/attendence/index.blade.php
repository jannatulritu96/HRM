@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-sm-8">
            <h4 class="page-title">{{ $title }}</h4>
        </div>
        <div class="col-sm-4 text-right m-b-30">
            <a href="{{ route('attendence.upload') }}" class="btn btn-primary rounded"><i class="fa fa-plus"></i> Upload Bulk Attendence</a>
        </div>
    </div>
    <div class="row" style="margin-bottom: 10px">
        {{ Form::model(request(),['method'=>'get']) }}
        <div class="col-sm-6">
            {{ Form::date('date',null,['class'=>'form-control','placeholder'=>'Date']) }}
        </div>
        <div class="col-sm-4">
            {{ Form::select('status',['Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control','placeholder'=>'Please select status']) }}
        </div>
        <div class="col-sm-2">
            {{ Form::submit('Search',['class'=>'btn btn-warning']) }}
        </div>
        {{ Form::close() }}
    </div>
    <div class="row">
        <div class="col-md-12">
            <div>
                <table class="table table-striped custom-table m-b-0 datatable">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($attendences as $attendence)

                        <tr>
                            <td>{{ $attendence->date }}</td>
                            <td><a href="{{ route('attendence.show',$attendence->relUser->id) }}">{{ $attendence->relUser->name }}</a></td>
                            <td>
                                {{ $attendence->in_time.'-'.$attendence->out_time }}
                            </td>
                            <td>{{ $attendence->status }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $attendences->links() }}
            </div>
        </div>
    </div>
@endsection