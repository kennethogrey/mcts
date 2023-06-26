@extends('dashboard.permit')
@extends('dashboard.layout')
@section('title','Dashboard | Order')
@section('content')

<!-- Hover table card start -->
<div class="col-sm-12">
    @livewire('all-orders')
</div>
<!-- Hover table card end -->

@endsection