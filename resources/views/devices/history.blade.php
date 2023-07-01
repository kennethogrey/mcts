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
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Device Trip History</h5>
            <div class="d-flex">
                <div class="p-15 p-b-0">
                    <div class="form-group form-primary">
                        <select id="year" name="year" class="form-control">
                            <option value="">Select Year</option>
                            @php
                                $currentYear = date('Y');
                                $startYear = 2000; // Change this value as per your requirement
                            @endphp
                            @for ($year = $currentYear; $year >= $startYear; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="p-15 p-b-0">
                    <div class="form-group form-primary">
                        <select id="month" name="month" class="form-control">
                            <option value="">Select Month</option>
                            @php
                                $months = [
                                    1 => 'January',
                                    2 => 'February',
                                    3 => 'March',
                                    4 => 'April',
                                    5 => 'May',
                                    6 => 'June',
                                    7 => 'July',
                                    8 => 'August',
                                    9 => 'September',
                                    10 => 'October',
                                    11 => 'November',
                                    12 => 'December',
                                ];
                            @endphp
                            @foreach ($months as $monthNumber => $monthName)
                                <option value="{{ $monthNumber }}">{{ $monthName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="p-15 p-b-0">
                    <div class="form-group form-primary">
                        <select id="day" name="day" class="form-control">
                            <option value="">Select Day</option>
                            @php
                                $days = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];
                            @endphp
                            @foreach ($days as $dayNumber)
                                <option value="{{ $dayNumber }}">{{ $dayNumber }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>             
            </div>
        </div>
    </div>
    
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
                                rsort($files); // Sort files in descending order

                                $perPage = 12; // Number of files per page
                                $currentPage = request()->get('page', 1); // Get the current page number
                                $totalFiles = count($files);

                                // Create a paginator instance manually
                                $files = new \Illuminate\Pagination\LengthAwarePaginator(
                                    array_slice($files, ($currentPage - 1) * $perPage, $perPage),
                                    $totalFiles,
                                    $perPage,
                                    $currentPage,
                                    [
                                        'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
                                        'pageName' => 'page',
                                    ]
                                );
                            @endphp    
                            @foreach($files as $file)
                                @php
                                    $fileName = basename($file);
                                    $fileNameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
                                @endphp
                                <div class="col-lg-12 col-xl-4">
                                    <!-- Basic map start -->
                                    <a href="{{route('map.file',$file)}}">
                                        <div class="card">
                                            <div class="card-block">
                                                <!-- Add a div with a unique ID for each map -->
                                                <div id="map-{{ $device->id }}-{{ $fileNameWithoutExt }}" class="set-map"
                                                    style="height: 200px;"></div>
                                            </div>
                                            <div class="card-header">
                                                <h5>
                                                    {{ $fileNameWithoutExt }} on
                                                    @php
                                                        $day = \Carbon\Carbon::parse($fileNameWithoutExt)->format('l');
                                                    @endphp
                                                    {{ $day }}
                                                </h5>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- Basic map end -->
                                </div>
                                @push('scripts')
                                    <script>
                                        function filterFiles() {
                                            var selectedYear = $('select[name="year"]').val();
                                            var selectedMonth = $('select[name="month"]').val();
                                            var selectedDay = $('select[name="day"]').val();
                                    
                                            $('.col-lg-12.col-xl-4').each(function() {
                                                var mapContainer = $(this);
                                                var fileNameWithoutExt = mapContainer.find('.card-header h5').text().trim();
                                                var fileDate = fileNameWithoutExt.split(' ')[0];
                                    
                                                if (
                                                    (selectedYear === '' || fileDate.includes(selectedYear)) &&
                                                    (selectedMonth === '' || fileDate.includes(selectedMonth))&&
                                                    (selectedDay === '' || fileDate.includes(selectedDay))
                                                ) {
                                                    mapContainer.show();
                                                } else {
                                                    mapContainer.hide();
                                                }
                                            });
                                        }
                                    
                                        $(document).ready(function() {
                                            filterFiles(); // Initial filtering
                                    
                                            $('select[name="year"], select[name="month"], select[name="day"]').change(function() {
                                                filterFiles();
                                            });
                                    
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
                    <div class="pagination justify-content-center">
                        {{ $files->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
            <!-- Page body end -->
        </div>
    </div>
</div>
@endsection