@extends('dashboard.permit')
@extends('dashboard.layout')
@section('title','Dashboard | Users')
@section('content')

<!-- Hover table card start -->
<div class="col-sm-12">
    @livewire("all-users")
</div>
<!-- Hover table card end -->

@endsection
