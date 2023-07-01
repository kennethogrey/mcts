@extends('dashboard.layout')
@section('title', 'Dashboard | MCTS')
@section('content')
@if (auth()->user()->role == 2 && auth()->user()->status == 1)
<div class="pcoded-inner-content">
    <!-- Main-body start -->
    <div class="main-body">
        <div class="page-wrapper">
            <!-- Page-body start -->
            <div class="page-body">
                <div class="row">
                    <!-- Material statustic card start -->
                    <div class="col-xl-3 col-md-12">
                        <a href="{{route('users.index')}}">
                            <div class="card mat-stat-card" style="height: 85%;">
                                <div class="card-block d-flex align-items-center justify-content-center"
                                    style="height: 100%;">
                                    <div class="text-center my-2">
                                        <i class="far fa-user text-c-purple f-30"></i>
                                        <h5 style="font-size: 24px;">{{ $user_count }}</h5>
                                        <a href="{{route('users.index')}}" class="text-muted m-b-0" style="font-size: 16px;">Users</a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xl-3 col-md-12">
                        <a href="{{ route('device.index') }}">
                            <div class="card mat-stat-card" style="height: 85%;">
                                <div class="card-block d-flex align-items-center justify-content-center"
                                    style="height: 100%;">
                                    <div class="text-center my-2">
                                        <i class="far fa-hdd text-c-purple f-30"></i>
                                        <h5 style="font-size: 24px;">{{ $devices }}</h5>
                                        <a href="{{route('device.index')}}" class="text-muted m-b-0" style="font-size: 16px;">Registered Devices</a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-12">
                        <a href="{{route('user.orders')}}">
                            <div class="card mat-stat-card" style="height: 85%;">
                                <div class="card-block d-flex align-items-center justify-content-center"
                                    style="height: 100%;">
                                    <div class="text-center my-2">
                                        <i class="far fa-file-alt text-c-red f-30"></i>
                                        <h5 style="font-size: 24px;">{{ $user_orders }}</h5>
                                        <a href="{{route('user.orders')}}" class="text-muted m-b-0" style="font-size: 16px;">New Orders</a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>


                    <div class="col-xl-3 col-md-12">
                        <a href="#">
                            <div class="card mat-stat-card" style="height: 85%;">
                                <div class="card-block d-flex align-items-center justify-content-center"
                                    style="height: 100%;">
                                    <div class="text-center my-2">
                                        <i class="far fa-user text-c-purple f-30"></i>
                                        <h5 style="font-size: 24px;">{{ $session_count }}</h5>
                                        <a href="#" class="text-muted m-b-0" style="font-size: 16px;">Traffic</a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- Material statustic card end -->

                    <!-- All Device Locations -->
                    <div class="col-xl-12 col-md-12">
                        <div class="card" style="height: 520px">
                            <div class="card-header">
                                <h5>Active Device Locations</h5>
                            </div>
                            <div class="card-block">
                                <div id="map" class="set-map"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page-body end -->
        </div>
        <div id="styleSelector"> </div>
    </div>
</div>
@elseif (auth()->user()->role == 1 && auth()->user()->status == 1)
<div class="pcoded-inner-content">
    <!-- Main-body start -->
    <div class="main-body">
        <div class="page-wrapper">
            <!-- Page-body start -->
            <div class="page-body">
                <div class="row">
                    <!-- All Device Locations -->
                    <div class="col-xl-12 col-md-12">
                        <div class="card" style="height: 520px">
                            <div class="card-header">
                                <h5>Your Device Locations</h5>
                            </div>
                            <div class="card-block">
                                <div id="map2" class="set-map"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page-body end -->
        </div>
        <div id="styleSelector"> </div>
    </div>
</div>
@else
<script>
    window.location.href = "{{route('device.index')}}";
</script>
@endif
@endsection
@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
@endsection
@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <!-- Snake animation plugin -->
    <script src="{{ asset('assets/js/L.Polyline.SnakeAnim.js') }}"></script>
    <script>
        var map;
        map = L.map('map');
        map.setView([0.3476, 32.5825], 13);

        //Map view continues
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        //Google street markers
        var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });
        googleStreets.addTo(map);

        var counter = 0;
        var latlngs = [];
        // Retrieve the updated coordinates from the DB every 5 second
        setInterval(function() {
            $.getJSON('/marker', function(data) {
                var coordinates = data.currentCoordinate;
                coordinates.forEach((item) => {
                    //console.log(item.id, item.device_id, item.latitude);
                    if (coordinates.length > 0) {
                        var marker = L.marker([0, 0]).addTo(map);
                        marker.setLatLng([item.latitude, item.longitude]);
                        latlngs.push([item.latitude, item.longitude]);
                    }
                    marker.on('click', mapClick);
                    var pop = L.popup();

                    function mapClick(e) {
                        // Use a reverse geocoding service to get the name of the place
                        var latlng = e.latlng;
                        var geocoder = L.Control.Geocoder.nominatim();
                        geocoder.reverse(latlng, map.options.crs.scale(map.getZoom()), function(
                            results) {
                            if (results.length > 0) {
                                // Get the name of the place
                                var name = results[0].name;
                            }
                            pop
                                .setLatLng(e.latlng)
                                .setContent("The current location of " + coordinates[0]
                                    .coordinates.name + " is " + e.latlng.toString() +
                                    " the place is called " + name)
                                .openOn(map);
                        });
                    }
                });
                var roadLine = L.polyline(latlngs, {
                    color: 'green',
                    snakingSpeed: 200
                }).addTo(map);
                roadLine.snakeIn();
            });
        }, 10000)
    </script>
    <script>
        var map2;
        map2 = L.map('map2');
        map2.setView([0.3476, 32.5825], 13);

        //Map view continues
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map2);
        //Google street markers
        var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });
        googleStreets.addTo(map2);

        var counter = 0;
        var latlngs = [];

        // Retrieve the updated coordinates from the DB every 5 seconds
        setInterval(function() {
            $.getJSON('/marker', function(data) {
                var coordinates = data.currentCoordinate;
                var deviceIds = data.device;

                for (var deviceId of deviceIds) {
                    //console.log(deviceId);
                    coordinates.forEach((item) => {
                        if (coordinates.length > 0 && deviceId === item.device_id) {
                            var marker = L.marker([0, 0]).addTo(map2);
                            marker.setLatLng([item.latitude, item.longitude]);
                            latlngs.push([item.latitude, item.longitude]);

                            marker.on('click', mapClick);
                            var pop = L.popup();

                            function mapClick(e) {
                                var latlng = e.latlng;
                                var geocoder = L.Control.Geocoder.nominatim();
                                geocoder.reverse(latlng, map2.options.crs.scale(map2.getZoom()), function(results) {
                                    if (results.length > 0) {
                                        var name = results[0].name;
                                        pop
                                            .setLatLng(e.latlng)
                                            .setContent("The current location of " + coordinates[0].coordinates.name +
                                                " is " + e.latlng.toString() + " the place is called " + name)
                                            .openOn(map2);
                                    }
                                });
                            }
                        }
                    });
                }
            });

            var roadLine = L.polyline(latlngs, {
                color: 'green',
                snakingSpeed: 200
            }).addTo(map2);
            roadLine.snakeIn();
        }, 10000);

    </script>
@endpush('scripts')