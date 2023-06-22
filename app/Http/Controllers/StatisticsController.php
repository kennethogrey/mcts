<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use File;
use App\Models\Order;
use Stevebauman\Location\Facades\Location;

class StatisticsController extends Controller
{
   public function activate_user($id)
    {
        $user_status = User::where('id', $id)->first();
        if($user_status->status == 1) {
            User::where('id', $id)->update(['status' => 0]);
            return redirect()->back()->with('status', 'The User Has Been Deactivated Successfully');
        }else {
            User::where('id', $id)->update(['status' => 1]);
            return redirect()->back()->with('status', 'The User Has Been Activated Successfully');
        }
    }

    public function user_photo(Request $request)
    {
        //delete the previous one
        $user_photo = User::where('id',auth()->user()->id)->first();

        $fileloc = 'app/public/profile_photo/'.$user_photo->profile_photo_path;
        $filename = storage_path($fileloc);
        //dd($filename);

        if(File::exists($filename)) {
            File::delete($filename);
        }

        $user_photo = User::where('id',auth()->user()->id)->first();
        $image = $request->file('image');
        if($image != null) {
            $imageName = time().'.'.$image->extension();
            $image->move(storage_path('app/public/profile_photo'),$imageName);
            $user_photo->update(['profile_photo_path' => $imageName]);

        }

        return redirect()->route('users.index')->with('status','User Profile-Photo Updated Successfully');
    }

    public function device_owner()
    {
        return view('dashboard.device');
    }

    //orders
    public function device_order(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'phone' => 'required|min:10',
            'devices' => 'required',
            'message' => 'required|max:400',
        ]);

        Order::create($input);
        return redirect()->back()->with('status','Your Order has been Successfully Received, Wait to be contacted by the Administrators');;
    }

    public function device_orders()
    {
        $orders = Order::where('status',0)->get();
        return view('users.orders',compact('orders'));
    }

    public function destroy_orders($id)
    {
        DB::table('orders')->where('id',$id)->delete();
        return redirect()->back()->with('status', 'The Order Was Been Deleted Successfully');
    }

    // leaflet.js
    public function my_location()
    {
        $ip = \Request::getClientIp(); //for dynamic $ips
        $currentUserInfo = Location::get($ip);
        //dd($currentUserInfo);
        return view('leaflet_maps.mylocation',compact('currentUserInfo'));
    }
}
