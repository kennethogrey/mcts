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
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
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

        var color_counter = 0;
        var latlngs = [];
        for (let line of lines) {
            color_counter++;
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

                            if(color_counter == 1)
                            {
                                // Create a green icon for the marker
                                var greenIcon = L.icon({
                                    iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                                    iconSize: [25, 41],
                                    iconAnchor: [12, 41],
                                    popupAnchor: [1, -34],
                                    shadowSize: [41, 41]
                                });
                                marker.setIcon(greenIcon);
                            }
                            if(color_counter == lines.length-1)
                            {
                                // Create a green icon for the marker
                                var redIcon = L.icon({
                                    iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                                    iconSize: [25, 41],
                                    iconAnchor: [12, 41],
                                    popupAnchor: [1, -34],
                                    shadowSize: [41, 41]
                                });
                                marker.setIcon(redIcon);
                            }

                            marker.on('click', mapClick);
                            var pop = L.popup();

                            function mapClick(e) {
                                var latlng = e.latlng;
                                var geocoder = L.Control.Geocoder.nominatim();
                                geocoder.reverse(latlng, map.options.crs.scale(map.getZoom()), function(results) {
                                    if (results.length > 0) {
                                        var name = results[0].name;
                                        pop
                                            .setLatLng(e.latlng)
                                            .setContent("This location "  +
                                                " is at " + e.latlng.toString() + ", the place is called " + name)
                                            .openOn(map);
                                    }
                                });
                            }
                        }
                    }
                }
            }
        }

        if(latlngs.length > 1)
        {
            var roadLine = L.polyline(latlngs, {color: 'green', snakingSpeed: 200}).addTo(map);
            roadLine.snakeIn();
            //console.log(latlngs)
        }
    });
</script>
@endpush