@if(auth()->user()->role==0 || auth()->user()->status==0)
<script>
    window.location.href = "{{route('device.index')}}";
</script>
@endif
@extends('dashboard.layout')
@section('title','Dashboard | My Location')
@section('content')

<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <!-- Page body start -->
            <div class="page-body">
                <div class="col-lg-12">
                    <!-- Map View map start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Map View</h5>
                            <span>Your Location</span>
                        </div>
                        <div class="card-block">
                            <div id="map" class="set-map"></div>
                        </div>
                    </div>
                    <!-- Map View map end -->
                </div>
                <div class="col-lg-12">
                    <!-- Street View map start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Street View</h5>
                            <span>Your Location</span>
                        </div>
                        <div class="card-block">
                            <div id="map2" class="set-map"></div>
                        </div>
                    </div>
                    <!-- Street View map end -->
                </div>
            </div>
        </div>
        <!-- Page body end -->
    </div>
</div>

@endsection
@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
crossorigin=""/>
@endsection
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
crossorigin=""></script>

<script>
    'use strict';
    $(document).ready(function() {

        //Variables from Stevebauman location package
        var latitude = @json($currentUserInfo->latitude);
        var longitude = @json($currentUserInfo->longitude);
        // console.log(latitude);
        // console.log(longitude);
        
        //Map view
        var map;
        map = L.map('map');
        map.setView([latitude, longitude], 13);

        //Street view
        var map2;
        map2 = L.map('map2');
        map2.setView([latitude, longitude], 13);

        navigator.geolocation.watchPosition(success, error, {enableHighAccuracy:true});
        let marker, circle, mark;
        function success(pos)
        {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            const accuracy = pos.coords.accuracy;

            marker = L.marker([lat, lng]).addTo(map);
            mark = L.marker([lat, lng]).addTo(map2);
            //circle = L.circle([lat, lng], {radius:accuracy}).addTo(map);

            marker.on('click', mapView);
            var popup = L.popup();

            function mapView(e) {
                popup
                    .setLatLng(e.latlng)
                    .setContent("You current location is " + e.latlng.toString())
                    .openOn(map);
            }

            mark.on('click', streetView);
            var popup = L.popup();
            function streetView(e) {
                popup
                    .setLatLng(e.latlng)
                    .setContent("You current location is " + e.latlng.toString())
                    .openOn(map2);
            }

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
        }

        function error(err) 
        {
            if(err.code===1){
                alert("Please allow geolocation access");
            }else{
                alert("Cannot get current location"); 
            }
        }

        
        
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map2);

        //google street
        var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        });
        googleStreets.addTo(map2);

        //google satellite
        var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        });
        googleSat.addTo(map2);


    });
    
</script>

@endpush
