@extends('dashboard.permit')
@extends('dashboard.layout')
@section('title','Edit | Device')
@section('content')

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Edit Device {{ $device->name }}</h5>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Basic Inputs</h4>
                    <form method="POST" action="{{ route('device.update', $device) }}">
                        @csrf
                        @method('PUT')    
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Device Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{ $device->name }}">
                            </div>
                        </div>    
                        {{--  <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Select User</label>
                            <div class="col-sm-10">
                                <select name="user" class="form-control" required>
                                    <option value="">-User-</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>  --}}
                        <button type="submit" class="btn waves-effect waves-light btn-primary"><i class="icofont icofont-user-alt-3"></i> Submit</button>
                    </form>
                </div>
            </div>
            <!-- Basic Form Inputs card end -->
        </div>
    </div>
</div>

@endsection