<div>
       
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
</div>
