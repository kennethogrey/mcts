@if (auth()->user()->role == 2 && auth()->user()->status == 1)
    @extends('dashboard.layout')
    @section('title', 'Dashboard | MCTS')
    @section('content')

        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-body start -->
                    <div class="page-body">
                        <div class="row">
                            <!-- Material statustic card start -->
                            <div class="col-xl-3 col-md-12">
                                <a href="#">
                                    <div class="card mat-stat-card" style="height: 85%;">
                                        <div class="card-block d-flex align-items-center justify-content-center"
                                            style="height: 100%;">
                                            <div class="text-center my-2">
                                                <i class="far fa-user text-c-purple f-30"></i>
                                                <h5 style="font-size: 24px;">{{ $unique_vistors }}</h5>
                                                <a href="#" class="text-muted m-b-0" style="font-size: 16px;">New
                                                    Visitors</a>
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
                                                <h5 style="font-size: 24px;">{{ $user_count }}</h5>
                                                <a href="#" class="text-muted m-b-0" style="font-size: 16px;">Users</a>
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
                                                <i class="far fa-file-alt text-c-red f-30"></i>
                                                <h5 style="font-size: 24px;">{{ $user_orders }}</h5>
                                                <a href="#" class="text-muted m-b-0" style="font-size: 16px;">New Orders</a>
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
                                                <a href="#" class="text-muted m-b-0" style="font-size: 16px;">Sessions</a>
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
                            <!--  sale analytics start -->
                            {{--  <div class="col-xl-6 col-md-12">
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
                                                            <h6 class="f-w-700">@if ($user->role == 1){{__('Normal User')}} @elseif($user->role == 2) {{__('Administrator')}} @else{{('No Role')}} @endif<i class="fas fa-level-up-alt text-c-green m-l-10"></i></h6>
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
                            </div>  --}}
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
        window.location.href = "{{ route('device.index') }}";
    </script>
@endif


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
@endpush('scripts')
