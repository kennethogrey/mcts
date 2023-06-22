@extends('dashboard.permit')
@extends('dashboard.layout')
@section('title','Dashboard | Edit User')
@section('content')

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h5>Edit {{ $edit_user->name }}'s Details</h5>
                </div>
                <div class="card-block">
                    <h4 class="sub-title">Basic Inputs</h4>
                    <form method="POST" action="{{ route('users.update', $edit_user->id) }}" enctype="multipart/form-data">
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
                            <label class="col-sm-2 col-form-label">Full Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{ $edit_user->name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email" value="{{ $edit_user->email }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Full Location</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="location" value="{{ $edit_user->location }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Contact</label>
                            <div class="col-sm-10">
                                <h4 class="sub-title">Format +256772651432 Please use this format to receice SMS</h4>
                                <input type="text" class="form-control" name="contact" value="{{ $edit_user->contact }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Select Role</label>
                            <div class="col-sm-10">
                                <select name="role" class="form-control" required>
                                    <option value="0">No Role</option>
                                    <option value="1">Normal User</option>
                                    <option value="2">Administrator</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn waves-effect waves-light btn-primary"><i class="icofont icofont-user-alt-3"></i> Submit</button>
                    </form>
                </div>
            </div>
            <!-- Basic Form Inputs card end -->
        </div>
    </div>
</div>

@endsection