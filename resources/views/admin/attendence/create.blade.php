@extends('admin.layouts.master')
@section('content')
    <div class="row">
        <div class="col-sm-offset-3 col-sm-6">
            <div class="modal-body">
                {{ Form::open(['route'=>['attendence.store'],'files'=>true]) }}
                @include('admin.layouts._validation_messages')
                <fieldset>
                    <legend>Upload bulk attendence</legend>
                    <div class="form-group">
                        <label>attendence file </label>
                        {{ Form::file('attendence_file',['class'=>'form-control','placeholder'=>'attendence file']) }}
                    </div>
                </fieldset>
                <div class="m-t-20 text-center">
                    <button class="btn btn-primary">Upload attendence</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection