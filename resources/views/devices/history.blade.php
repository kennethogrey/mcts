@extends('dashboard.layout')
@section('title','Location | History')
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
@endpush
@section('content')
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <!-- Page body start -->
            <div class="page-body">
                <div class="row">
                @forelse($devices as $device)
                        @php
                            $filePath = storage_path('app/public/TripHistories/'.$device->user.'/'.$device->id.'/');
                            $files = glob($filePath . '*.txt');
                        @endphp    
                        @foreach($files as $file)
                            @php
                                $fileName = basename($file);
                                $fileNameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
                            @endphp
                            <div class="col-lg-12 col-xl-4">
                                <!-- Basic map start -->
                                <div class="card">
                                    <div class="card-block">
                                        <!-- Add a div with a unique ID for each map -->
                                        <div id="map-{{ $device->id }}-{{ $fileNameWithoutExt }}" class="set-map"
                                             style="height: 400px;"></div>
                                    </div>
                                    <div class="card-header">
                                        <h5>Trip History
                                            <a href="{{ asset('storage/TripHistories/'.$device->user.'/'.$device->id.'/'.$fileName) }}" download>Download File</a>
                                        </h5>
                                    </div>
                                    <div>
                                        <span>
                                            for {{ $device->name }} as of {{ $fileNameWithoutExt }} on
                                            @php
                                                $day = \Carbon\Carbon::parse($fileNameWithoutExt)->format('l');
                                            @endphp
                                            {{ $day }}
                                        </span>
                                    </div>
                                </div>
                                <!-- Basic map end -->
                            </div>
                            @push('scripts')
                                <script>
                                    $(document).ready(function() {
                                    // Loop through each map container
                                    $('.set-map').each(function() {
                                        // Get the ID of the device associated with this map container
                                        var mapId = "map-{{ $device->id }}-{{ $fileNameWithoutExt }}";

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
                                });
                                </script>
                            @endpush
                        @endforeach
                    @empty
                        <div class="alert alert-Danger">
                            {{ __('No Device History Available') }}
                        </div>
                    @endforelse 
                </div>
            </div>
        </div>
        <!-- Page body end -->
    </div>
</div>
@endsection
