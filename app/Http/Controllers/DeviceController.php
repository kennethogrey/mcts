<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Models\Device;
use App\Models\Location;
use App\Models\User;
use Carbon\Carbon;
use App\Models\GeoFence;



class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('devices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('role',1)->get();
        return view('devices.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDeviceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeviceRequest $request)
    {
        $deviceTable = new Device();
        $deviceTable->name = $request->device_name;
        $deviceTable->user = $request->device_user;
        $deviceTable->save();
        $device_id = Device::latest()->pluck('id')->first();
        Location::create([
            'device_id' => $device_id,
            'latitude'=> '0.34762300',
            'longitude' => '32.58252300',
        ]);
        return redirect()->route('device.index')->with('status','New Device Registered Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function show(Device $device)
    {
        $id = $device->id;
        $mytime = Carbon::now();
        $timeNow = $mytime->toDateTimeString();

        //Geofences
        $geofence = GeoFence::where('device_id',$id)->pluck('coordinates')->first();
        return view('devices.show',compact('device','timeNow','geofence'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function marker(Device $device)
    {
        $device = Device::where('user', auth()->user()->id)->pluck('id');
        $currentCoordinate = Location::with('coordinates')->get();
        //dd($currentCoordinate);
        $geofences = GeoFence::all();
        return response()->json([
            'currentCoordinate' => $currentCoordinate,
            'device' => $device
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device)
    {
        $users = User::where('role',1)->get();
        return view('devices.edit',compact('device','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDeviceRequest  $request
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeviceRequest $request, Device $device)
    {
        $device->update($request->validated());
        $device->name = $request->input('name');
        //$device->user = $request->input('user');
        return redirect()->route('device.index')->with('status', 'The Device\'s Details Has Been Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->back()->with('status', 'The Device Has Been Deleted Successfully');
    }
}
