
@push('scripts')
                            <script>
                                $(document).ready(function() {
                                // Loop through each map container
                                $('.set-map').each(function() {
                                    // Get the ID of the device associated with this map container
                                    var mapId = "map-{{ $device->id }}-{{ $fileNameWithoutExt }}";

                                    // Set up the Leaflet map for this device
                                    var map = L.map(mapID).setView([0.37734, 32.6258], 8);
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        attribution: '&copy; OpenStreetMap contributors'
                                    }).addTo(map);

                                    let fileContents = @json(file_get_contents($filePath));
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