@extends('dashboard.layout')
@section('title','File-Points | Locations')
@section('content')

@if($file)
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page body start --> 
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            <!-- Basic map start -->
                            <div class="card" style="height: 500px">
                                <div class="card-header">
                                    <h5>
                                        @php
                                            $fileName = basename($file);
                                            $fileNameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
                                        @endphp
                                        Trip History as of 
                                        {{ $fileNameWithoutExt }} on
                                        @php
                                            $day = \Carbon\Carbon::parse($fileNameWithoutExt)->format('l');
                                        @endphp
                                        {{ $day }}
                                    </h5>
                                </div>
                                <div class="card-block">
                                    <div id="map" class="set-map"></div>
                                </div>
                            </div>
                            <!-- Basic map end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
<div class="pcoded-inner-content">
        <!-- Primary-color Breadcrumb card start -->
        <div class="card borderless-card">
            <div class="card-block primary-breadcrumb">
                <div class="breadcrumb-header">
                    <h5>No File Availble</h5>
                </div>
            </div>
        </div>
        <!-- Primary-color Breadcrumb card end -->
    </div>
@endif
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
<!-- Snake animation plugin -->
<script src="{{asset('assets/js/L.Polyline.SnakeAnim.js')}}"></script>

<script>
    $(document).ready(function() {
        // Get the ID of the device associated with this map container
        var mapId = "map";

        // Set up the Leaflet map for this device
        var map = L.map(mapId).setView([0.37734, 32.6258], 8);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let fileContents = @json(file_get_contents($file));
        let lines = fileContents.split('\n');

        var latlngs = [];
        for (let line of lines) {
            if (line.trim() !== '') { //eliminate empty lines
                let data = JSON.parse(line);
                if (data) {
                    for (let item of data) {
                        let latitude = item.latitude;
                        let longitude = item.longitude;
                        let device_id = item.device_id;
                        // Check if the current array exists in latlngs
                        if (!latlngs.some(arr => arr[0] === latitude && arr[1] === longitude)) {
                            var marker = L.marker([latitude, longitude]).addTo(map);
                            latlngs.push([latitude, longitude]);
                        }
                    }
                }
            }
        }
        var roadLine = L.polyline(latlngs, {color: 'green', snakingSpeed: 200}).addTo(map);
        roadLine.snakeIn();
        //console.log(latlngs)
    });
</script>
@endpush