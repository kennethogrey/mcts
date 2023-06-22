@if(auth()->user()->role==2 && auth()->user()->status==1)
    @extends('dashboard.layout')
    @section('title','Dashboard | MCTS')
    @section('content')

        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-body start -->
                    <div class="page-body">
                        <div class="row">
                            <!-- Material statustic card start -->
                            <div class="col-xl-4 col-md-12">
                                <div class="card mat-stat-card">
                                    <div class="card-block">
                                        <div class="row align-items-center b-b-default">
                                            <div class="col-sm-6 b-r-default p-b-20 p-t-20">
                                                <div class="row align-items-center text-center">
                                                    <div class="col-4 p-r-0">
                                                        <i class="far fa-user text-c-purple f-24"></i>
                                                    </div>
                                                    <div class="col-8 p-l-0">
                                                        <h5>{{$unique_vistors}}</h5>
                                                        <p class="text-muted m-b-0">New Visitors</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 p-b-20 p-t-20">
                                                <div class="row align-items-center text-center">
                                                    <div class="col-4 p-r-0">
                                                        <i class="far fa-user text-c-purple f-24"></i>
                                                    </div>
                                                    <div class="col-8 p-l-0">
                                                        <h5>{{$user_count}}</h5>
                                                        <p class="text-muted m-b-0">Users</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                                <div class="row align-items-center text-center">
                                                    <div class="col-4 p-r-0">
                                                        <i class="far fa-file-alt text-c-red f-24"></i>
                                                    </div>
                                                    <div class="col-8 p-l-0">
                                                        <h5>{{$user_orders}}</h5>
                                                        <p class="text-muted m-b-0">New Orders</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 p-b-20 p-t-20">
                                                <div class="row align-items-center text-center">
                                                    <div class="col-4 p-r-0">
                                                        <i class="far fa-user text-c-purple f-24"></i>
                                                    </div>
                                                    <div class="col-8 p-l-0">
                                                        <h5>{{$session_count}}</h5>
                                                        <p class="text-muted m-b-0">Sessions</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-12">
                                <div class="card mat-stat-card">
                                    <div class="card-block">
                                        <div class="row align-items-center b-b-default">
                                            <div class="col-sm-6 b-r-default p-b-20 p-t-20">
                                                <div class="row align-items-center text-center">
                                                    <div class="col-4 p-r-0">
                                                        <i class="fas fa-share-alt text-c-purple f-24"></i>
                                                    </div>
                                                    <div class="col-8 p-l-0">
                                                        <h5>1000</h5>
                                                        <p class="text-muted m-b-0">Share</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 p-b-20 p-t-20">
                                                <div class="row align-items-center text-center">
                                                    <div class="col-4 p-r-0">
                                                        <i class="fas fa-sitemap text-c-green f-24"></i>
                                                    </div>
                                                    <div class="col-8 p-l-0">
                                                        <h5>600</h5>
                                                        <p class="text-muted m-b-0">Network</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                                <div class="row align-items-center text-center">
                                                    <div class="col-4 p-r-0">
                                                        <i class="fas fa-signal text-c-red f-24"></i>
                                                    </div>
                                                    <div class="col-8 p-l-0">
                                                        <h5>350</h5>
                                                        <p class="text-muted m-b-0">Returns</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 p-b-20 p-t-20">
                                                <div class="row align-items-center text-center">
                                                    <div class="col-4 p-r-0">
                                                        <i class="fas fa-wifi text-c-blue f-24"></i>
                                                    </div>
                                                    <div class="col-8 p-l-0">
                                                        <h5>100%</h5>
                                                        <p class="text-muted m-b-0">Connections</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-12">
                                <div class="card mat-clr-stat-card text-white green ">
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-3 text-center bg-c-green">
                                                <i class="fas fa-star mat-icon f-24"></i>
                                            </div>
                                            <div class="col-9 cst-cont">
                                                <h5>4000+</h5>
                                                <p class="m-b-0">Ratings Received</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mat-clr-stat-card text-white blue">
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-3 text-center bg-c-blue">
                                                <i class="fas fa-trophy mat-icon f-24"></i>
                                            </div>
                                            <div class="col-9 cst-cont">
                                                <h5>17</h5>
                                                <p class="m-b-0">Achievements</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Material statustic card end -->

                            <!-- All Device Locations -->
                            <div class="col-xl-12 col-md-12">
                                <div class="card" style="height: 520px">
                                    <div class="card-header">
                                        <h5>Active Devices</h5>
                                    </div>
                                    <div class="card-block">
                                        <div id="map" class="set-map"></div>
                                    </div>
                                </div>
                            </div>
                            <!--  sale analytics start -->
                            <div class="col-xl-6 col-md-12">
                                <div class="card table-card">
                                    <div class="card-header">
                                        <h5>Active Users</h5>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="table table-hover m-b-0 without-header">
                                                <tbody>
                                                @forelse($registered_users as $user)
                                                    <tr>
                                                        <td>
                                                            <div class="d-inline-block align-middle">
                                                                <img src="assets/images/avatar-4.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                                <div class="d-inline-block">
                                                                    <h6>{{ $user->name }}</h6>
                                                                    <p class="text-muted m-b-0">{{ $user->location }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-right">
                                                            <h6 class="f-w-700">@if($user->role == 1){{__('Normal User')}} @elseif($user->role == 2) {{__('Administrator')}} @else{{('No Role')}} @endif<i class="fas fa-level-up-alt text-c-green m-l-10"></i></h6>
                                                        </td>
                                                    </tr>
                                                @empty  
                                                    <div class="d-inline-block align-middle">
                                                        <img src="assets/images/avatar-4.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                        <div class="d-inline-block">
                                                            <h6>{{ ('None is active') }}</h6>
                                                        </div>
                                                    </div>
                                                @endforelse  
                                                </tbody>
                                            </table>

                                        </div>
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

    @endsection
@else
    <script>
        window.location.href = "{{route('device.index')}}";
    </script>
@endif


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
    var map;
    map = L.map('map');
    map.setView([0.3476, 32.5825], 13);

    //Map view continues
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    //Google street markers
    var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
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
                if(coordinates.length > 0)
                {
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
                    geocoder.reverse(latlng, map.options.crs.scale(map.getZoom()), function(results) {
                        if (results.length > 0) {
                            // Get the name of the place
                            var name = results[0].name;
                        }
                    pop
                        .setLatLng(e.latlng)
                        .setContent("The current location of " +coordinates[0].coordinates.name+ " is " + e.latlng.toString()+ " the place is called "+name)
                        .openOn(map);
                    });
                }
            });
            var roadLine = L.polyline(latlngs, {color: 'green', snakingSpeed: 200}).addTo(map);
            roadLine.snakeIn();
        });
    }, 10000)

</script>    
@endpush('scripts')