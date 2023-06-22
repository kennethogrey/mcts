<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\User;
use App\Models\GeoFence;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OutGeoFence;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MapsController extends Controller
{
    public function activate_device($id)
    {
        $device_status = Device::where('id', $id)->first();
        if($device_status->status == 1) {
            Device::where('id', $id)->update(['status' => 0]);
            return redirect()->back()->with('status', 'The Device Has Been Deactivated Successfully');
        }else {
            Device::where('id', $id)->update(['status' => 1]);
            return redirect()->back()->with('status', 'The Device Has Been Activated Successfully');
        }
    }

    public function trip_history($id)
    {
        //data to be retrieved from text file as devt proceeds
        $devices = Device::with('geofences','coordinates')->where('id', $id)->get();
        return view('devices.history',compact('devices'));
        
    }

    public function storeGeofence(Request $request)
    {
        $geojson = $request->input('geojson');
        $device_id = $request->input('device_id');

        GeoFence::updateOrInsert(['device_id' => $device_id],[
            'coordinates' => $geojson, "created_at"=> Carbon::now(), "updated_at"=> now()
        ]);

        return response()->json([
            'message' => 'GeoJSON data received and stored in database successfully'
        ]);
    }

    public function destroyGeofence($id)
    {
        $geofence = GeoFence::where('device_id', $id)->first();
        if ($geofence) {
            $geofence->delete();
            return response()->json(['message' => 'geofence deleted']);
        } else {
            return response()->json(['error' => 'geofence not found'], 404);
        }
    }

    public function sendNotification(Request $request)
    {
        $user_id = $request->input('user_id');
        $device_id = $request->input('device_id');

        $user = User::where('id', $user_id)->first();
        $username = User::where('id', $user_id)->pluck('name')->first();
        $device = Device::where('id', $device_id)->pluck('name')->first();
        $contact = $user->contact;
        //Mail Notification
        $geofenceViolated = [
            'body' => 'Geo-Fence Violation Alert',
            'message' => 'Device '.$device.' appears to be out of the designated area which you earlier specified.',
            'url' => url('/'),
            'thankyou' => 'Take heed and make every necessary actions. Thank You'
        ];
        Notification::sendNow($user, new OutGeoFence($geofenceViolated));

        return response()->json([
            'message' => 'The message was sent Successfully'
        ]);

    }

    public function sendSMS(Request $request)
    {
        $user_id = $request->input('user_id');
        $device_id = $request->input('device_id');
        
        $contact = User::where('id', $user_id)->pluck('contact')->first();
        $username = User::where('id', $user_id)->pluck('name')->first();
        $device = Device::where('id', $device_id)->pluck('name')->first();
        
        $basic  = new \Vonage\Client\Credentials\Basic("911329d3", "DXJ8rtoucOlcwkF9");
        $client = new \Vonage\Client($basic);
        //SMS notification
        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS(256754428612, 'MCTS', 'Hello '.$username.' Device '.$device.' appears to be out of the designated area(GeoFence) which you earlier specified.')
        );
        $message = $response->current();
        if ($message->getStatus() == 0) {
            return response()->json([
                'message' => 'The message was Successfully sent'
            ]);
        } else {
            return response()->json([
                'message' => 'The message failed'
            ]);
        }
    }

    public function updateDeviceCoordinates(Request $request)
    {
        //$location_data = $request->input('device_location');
        $location_data = '{"channel":{"id":2160030,"name":"gps","latitude":"0.0","longitude":"0.0","field1":"device_id","field2":"latitude","field3":"longitude","field4":"time","field5":"date","field6":"alertStatus","created_at":"2023-05-23T12:27:28Z","updated_at":"2023-05-31T14:06:08Z","last_entry_id":149},"feeds":[{"created_at":"2023-05-31T15:03:01Z","entry_id":148,"field1":"3","field2":"0.33158982","field3":"32.57056000","field4":"18:1:39","field5":"31-5-2023","field6":"1"},{"created_at":"2023-05-31T15:04:33Z","entry_id":149,"field1":"1","field2":"0.33158982","field3":"32.57056000","field4":"18:3:11","field5":"31-5-2023","field6":"0"}]}';
        $jsonData = json_decode($location_data, true);
        $feeds = $jsonData['feeds']; 
        
        for ($i = 0; $i < count($feeds); $i++) {
            $entryId = $feeds[$i]['entry_id'];
            $device_id = $feeds[$i]['field1'];
            $latitude = $feeds[$i]['field2'];
            $longitude = $feeds[$i]['field3'];
            $updated_at = $feeds[$i]['created_at'];
            $time = $feeds[$i]['field4'];
            $date = $feeds[$i]['field5'];
            $alertStatus = $feeds[$i]['field6'];

            //Date issues
            $date = new \DateTime($updated_at);
            $formattedDate = $date->format('Y-m-d H:i:s');
            
            //Update the various device locations
            $result = Location::updateOrInsert(['device_id' => $device_id],[
                'latitude'=> $latitude,
                'longitude' => $longitude,
                'updated_at' => $formattedDate,
                'status' => $alertStatus,
            ]);

            // Check for the status of the button
            if($alertStatus == 1)
            {
                $this->makeAlert($device_id);
            }
    
            if($result){
                return ["result"=>"success"];
            }else{
                return ["result"=>"error"];
            }

        }
        //Log all coordinates to the file system
        $this->logCoordinatesToFile();
    }

    public function logCoordinatesToFile()
    {
        $devices = Device::with('geofences','coordinates')->get();

        //loop through all the devices
        foreach($devices as $device) 
        {
            $createdAt = Carbon::parse($device->coordinates->created_at)->format('Y-m-d');
            $latLngData = $device->coordinates->where('device_id', $device->id)->select('latitude', 'longitude','updated_at','device_id')->get();

            $filePath = storage_path('app/public/TripHistories/'.$device->user.'/'.$device->id.'/'.$createdAt.'.txt');
            $fileName = basename($filePath);
            $fileNameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
            
            $created_at = Carbon::parse($device->coordinates->created_at)->format('Y-m-d H:i:s'); // convert to Carbon instance
            $now = Carbon::now();
            
            if (File::exists($filePath) && $now->diffInHours($created_at) < 24)
            {
                $fileName = basename($filePath);
                // \Log::info($fileName);

                //loop to the last line of the file content time
                $file_contents = fopen($filePath, 'r');
                fseek($file_contents, 0, SEEK_END);
                //position of the last byte
                $last_byte_pos = ftell($file_contents);
                rewind($file_contents);
                while(ftell($file_contents) < $last_byte_pos) {
                    $content = fgets($file_contents);
                    $data = json_decode($content, true);
                }
                \Log::info($data);
                // looping through the contents of the file
                foreach ($data as $item) {
                    $new_latitude = $device->coordinates->where('device_id', $device->id)->pluck('latitude')->first();
                    $new_longitude = $device->coordinates->where('device_id', $device->id)->pluck('longitude')->first();
                    $file_latitude = $item['latitude'];
                    $file_longitude = $item['longitude'];
                    // compare with the incoming new coordinates
                    if($new_latitude == $file_latitude || $new_longitude == $file_latitude)
                    {
                        \Log::info($device->name.' Device Position not Changed as yet');
                    }else {
                        \Log::info($device->name.' Device changed location to '.$new_latitude.' and '.$new_longitude);
                        // Open the file in append mode
                        $file = fopen($filePath, 'a');
                        fwrite($file, $latLngData."\n");
                        fclose($file);
                    }
                }
                fclose($file_contents);
            } else {
                // The file either doesn't exist or was not created in the last 24 hours, therefore we create a new file
                \Log::info('false');
                Storage::disk('local')->put('public/TripHistories/'.$device->user.'/'.$device->id.'/'.$createdAt.'.txt', $latLngData."\n");
            }

        }
        return;
    }

    public function makeAlert($device_id)
    {
        $device = Device::where('id', $device_id)->pluck('name')->first();
        $user_id = Device::where('id', $device_id)->pluck('user')->first();
        $contact = User::where('id', $user_id)->pluck('contact')->first();
        $username = User::where('id', $user_id)->pluck('name')->first();

        // //SMS API
        $basic  = new \Vonage\Client\Credentials\Basic("911329d3", "DXJ8rtoucOlcwkF9");
        $client = new \Vonage\Client($basic);
        //SMS notification
        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS(256754428612, 'MCTS', 'Hello '.$username.' Device '.$device.' needs serious attention, as the emergency button has been clicked.')
        );
        return;   
    }
}
