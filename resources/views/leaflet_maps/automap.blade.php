@extends('leaflet_maps.autolayout')
@section('title','Auto | Process')
@section('content')
<div class="card-block table-border-style">
    <div class="table-responsive">
        <table class="table table-hover" id="device-table">
            <thead>
                <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>latitude</th>
                <th>longitude</th>
                <th>Map</th>
                </tr>
            </thead>
            <tbody>
                @foreach($device as $device)
                <tr>
                    <td>{{ $device->id }}</td>
                    <td>{{ $device->name }}</td>
                    <td>{{ $device->status }}</td>
                    <td>{{ $device->coordinates->latitude }}</td>
                    <td>{{ $device->coordinates->longitude }}</td>
                    <td>
                        <div class="map-container" id="map-{{ $device->id }}" style="width: 400px; height: 200px;"></div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
<!-- leaflet draw Plugin -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>
<!-- Turf.js Libraries -->
<script src='https://unpkg.com/@turf/turf@6/turf.min.js'></script>

<script>
    var device = {!! json_encode($device) !!};
    $(document).ready(function() {
        // Loop through each table row
        $('#device-table tbody tr').each(function() {
            // Get the ID and map container for this row
            var deviceId = parseInt($(this).find('td:first-child').text());
            var mapContainer = $(this).find('.map-container')[0];

            // Get the latitude and longitude for this device
            var latitude = $(this).find('td:nth-child(4)').text();
            var longitude = $(this).find('td:nth-child(5)').text();

            // Initialize the Leaflet map
            var map = L.map(mapContainer).setView([latitude, longitude], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
            
            // Define the marker outside of the $.getJSON callback function so we can update it later
            var marker = L.marker([0, 0]).addTo(map);
            var counter = 0;
            var notify = 0;
            setInterval(function() {
                $.getJSON('/marker', function(data) {
                    var coordinates = data.currentCoordinate;    
                    var filteredCoordinates = coordinates.filter(obj => obj.device_id === deviceId);
                    if (filteredCoordinates.length > 0) {
                        latitude = filteredCoordinates[0].latitude;
                        longitude = filteredCoordinates[0].longitude;

                        // Update the marker's position for the device
                        marker.setLatLng([latitude, longitude]);
                    }
                    //increment counter and notify
                    counter++;
                    notify++;

                    //GeoFence Violation Check by turf.js
                    var presentData = {!! json_encode($device->geofences->coordinates) !!}
                    if(presentData !== null) {
                        var myType = {!! $device->geofences->coordinates !!}
                        type = myType.geometry.type
                        // check if the point is within the polygon using turf.js library
                        coordinates = turf.point([longitude, latitude])
                        jsonData = {!!$device->geofences->coordinates!!}
                        poly = jsonData.geometry.coordinates[0]
                        //console.log(poly)
                        polygon = turf.polygon([poly])
                        isInside = turf.booleanPointInPolygon(coordinates, polygon);
                        console.log(isInside)
                        if(!isInside)
                        {
                            //delay notifications and SMS by 10 minutes(120 loops) to avoid overfloading email, every 5 seconds
                            if(notify >= 1)
                            {
                                return;
                            }else{
                                notifications(filteredCoordinates);
                            }
                        }else{
                            console.log("Device Still in Position")
                        }
                    }else{
                        console.log("No geofence set")
                    }
                    
                    if(counter <= 2)
                    {
                        // Update the map's view to center on the marker
                        map.setView([latitude, longitude], 13);
                    }else {
                        return;
                    }
                });
            }, 5000)

            function notifications(filteredCoordinates) {
                console.log("Device Out of Designated Area")
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //Email notifications
                $.ajax({
                    url: "{{ route('geofence.alert') }}",
                    type: "POST",
                    data: {
                        user_id: {{$device->user}},
                        device_id: filteredCoordinates[0].coordinates.id
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });

                //SMS calls
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //SMS notifications ajax
                $.ajax({
                    url: "{{ route('send.sms') }}",
                    type: "POST",
                    data: {
                        user_id: {{$device->user}},
                        device_id: filteredCoordinates[0].coordinates.id
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }
            setInterval(function(){
                location.reload();
            }, 600000); // 600000 milliseconds = 10 minutes

        });

        // Fetching device location after every 1 second at thinkSpeak
        function fetchData() {
            const url = 'https://api.thingspeak.com/channels/2160030/feeds.json?api_key=8X996CRIODRN4IK3&results=2';
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // updating the device coordinates from the controller
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    //update the device locations
                    $.ajax({
                        url: "{{ route('device.location') }}",
                        type: "POST",
                        data: {
                            device_location: JSON.stringify(data) 
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        setInterval(fetchData, 1000); //After every one second
    });
        
</script>
@endpush