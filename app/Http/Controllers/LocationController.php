<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Device;
use Carbon\Carbon;
use App\Models\GeoFence;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $device = Device::with('geofences','coordinates')->where('status', 1)->get();
        $myTime = Carbon::now();
        $timeNow = $myTime->toDateTimeString();
        //$geofence = GeoFence::pluck('coordinates')->first();
        return view('leaflet_maps.automap', compact('device'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $feature = $request->input('feature');
        dd($feature);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }

    public function addLocation(Request $request){
        $result = Location::updateOrInsert(['device_id' => $request->device_id],[
            'latitude'=>$request->latitude,
            'longitude' => $request->longitude,
        ]);

        if($result){
            return ["result"=>"success"];
        }else{
            return ["result"=>"error"];
        }

        // $location = Location::find($request->device_id);
        // if($location){
        //     $location->latitude = $request->latitude;
        //     $location->longitude = $request->longitude;
        //     $location->status = $request->status;
        //     $result = $location->save();
        //     if($result){
        //         return ["result"=>"data has been updated"];
        //     }else{
        //         return ["result"=>"error updating the data"];
        //     }
        // }else{
        //     $location = new Location();
        //     $location->device_id = $request->device_id;
        //     $location->latitude = $request->latitude;
        //     $location->longitude = $request->longitude;
        //     $location->status = $request->status;
        //     $result = $location->save();
        //     if($result){
        //         return ["result"=>"data has been saved"];
        //     }else{
        //         return ["result"=>"error saving the data"];
        //     }
        // }

    }
}
