@extends('dashboard.permit')
@extends('dashboard.layout')
@section('title','Device | Create')
@section('content')
@if(auth()->user()->status==1 && auth()->user()->role!=0)
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>Material Form Inputs</h5>
            <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
        </div>
        <div class="card-block">
            <form method="POST"  action="{{ route('device.store') }}" class="form-material">
                @csrf   
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group form-default">
                    <input type="text" name="device_name" class="form-control" required>
                    <span class="form-bar"></span>
                    <label class="float-label">Device Name</label>
                </div>
                <div class="form-group form-default">
                    <select name="device_user" class="form-control" required>
                        <option value=""></option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <span class="form-bar"></span>
                    <label class="float-label">Parent/Next of Kin</label>
                </div>
                <button type="submit" class="btn waves-effect waves-light btn-success"><i class="icofont icofont-user-alt-3"></i> Register</button>
            </form>
        </div>
    </div>
</div>

@endif
@endsection