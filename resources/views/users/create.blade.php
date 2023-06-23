@extends('dashboard.permit')
@extends('dashboard.layout')
@section('title','Dashboard | Register Users')
@section('content')

<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>Register new User</h5>
            <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
        </div>
        <div class="card-block">
            <form method="POST" action="{{ route('users.store') }}" class="form-material">
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
                    <input type="text" name="name" class="form-control" required>
                    <span class="form-bar"></span>
                    <label class="float-label">Full Name - eg "Jon Doe"</label>
                </div>
                <div class="form-group form-default">
                    <input type="email" name="email" class="form-control" required>
                    <span class="form-bar"></span>
                    <label class="float-label">Email - eg "example@gmail.com"</label>
                </div>
                <div class="form-group form-default">
                    <input type="text" name="location" class="form-control" required>
                    <span class="form-bar"></span>
                    <label class="float-label">Living Address - eg "Makerere-Kikoni"</label>
                </div>
                <div class="form-group form-default">
                    <select name="role" class="form-control" required>
                        <option value="" disabled selected hidden></option>
                        <option value="0" disabled>Select user role </option>
                        <option value="1">Normal User</option>
                        <option value="2">Administrator</option>
                    </select>
                    <span class="form-bar"></span>
                    <label class="float-label">Role</label>
                </div>
                <div class="form-group form-default">
                    <input type="text" name="contact" class="form-control" required>
                    <span class="form-bar"></span>
                    <label class="float-label">Telephone Number - eg "2567123456789"</label>
                </div>
                <button type="submit" class="btn waves-effect waves-light btn-success"><i class="icofont icofont-user-alt-3"></i> Register</button>
            </form>
        </div>
    </div>
</div>

{{--  <div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <!-- Basic Form Inputs card start -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Register New User</h3>
                </div>
                <div class="card-block">
                    <form class="md-float-material form-material" method="POST" action="{{ route('users.store') }}">
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
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Full Name</label>
                            <div class="col-sm-10">
                                <input type="name" name="name" class="form-control" :value="old('name')" required autofocus autocomplete="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" :value="old('email')" required autofocus autocomplete="username">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Full Location</label>
                            <div class="col-sm-10">
                                <input type="text" name="location" class="form-control" :value="old('location')" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Contact</label>
                            <div class="col-sm-10">
                                <h4 class="sub-title">Format 256772651432 Please use this format to receice SMS</h4>
                                <input type="text" class="form-control" name="contact" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Confirm Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                            </div>
                        </div>
                        <button type="submit" class="btn waves-effect waves-light btn-primary"><i class="icofont icofont-user-alt-3"></i> Submit</button>
                    </form>
                </div>
            </div>
            <!-- Basic Form Inputs card end -->
        </div>
    </div>
</div>  --}}
@endsection
