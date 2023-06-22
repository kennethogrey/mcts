
@extends('auth.layout')
@section('title','Reset Password | MCTS')
@section('content')

<section class="login-block">
    <!-- Container-fluid starts -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- Authentication card start -->

                    <form class="md-float-material form-material" method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <div class="text-center">
                            <img src="landings/assets/img/mctslogo.png" alt="logo" class="img-fluid">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center">Reset Password</h3>
                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                    <x-jet-validation-errors class="mb-4" />
                                    @if (session('status'))
                                        <div class="text-center">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                </div>
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                <div class="form-group form-primary">
                                    <input type="email" name="email" id="email" class="form-control" value="{{old('email', $request->email)}}" required autofocus autocomplete="username">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Your Email Address</label>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" id="password" name="password" class="form-control" required autocomplete="new-password">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Password</label>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Confirm Password</label>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Reset Password</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- end of form -->
            </div>
            <!-- end of col-sm-12 -->
        </div>
        <!-- end of row -->
    </div>
    <!-- end of container-fluid -->
</section>

@endsection