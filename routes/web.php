<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\MapsController;
use App\Http\Controllers\LocationController;
use App\Models\Visitor;
use Carbon\Carbon;
use App\Models\User;
use App\Jobs\RunBladeFileJob;
use App\Models\Device;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $visited_time = now()->format('H:i:s');
    $visited_date = now()->format('Y-m-d');
    $ip = \Request::getClientIp();

    $increase = Visitor::where('ip', $ip)->value('visits');
    $increase = $increase+1;
    $vistor = Visitor::updateOrInsert(['ip' => $ip],[
        'visits' => $increase, 'visited_time' => $visited_time, 'visited_date' => $visited_date,
        "created_at"=> Carbon::now(), "updated_at"=> now()
    ]);

    // Team members
    $team_members = User::where('role',2)->get();
    return view('landing_page.home',compact('team_members'));
});
Route::post('/device/order', [StatisticsController::class, 'device_order'])->name('make.order');





//protected routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        $devices = DB::table("devices")->count();
        $session_count = DB::table('sessions')->count();
        $unique_vistors = Visitor::where('visited_date', '>=', Carbon::now()->subDays(2))->count();
        $user_count = DB::table('users')->count();
        $user_orders = DB::table('orders')->count();
        //Active users
        $users_in_session = DB::table('sessions')->value('user_id');
        $registered_users = DB::table('users')->where('id',$users_in_session)->get();
        return view('dashboard.dashboard', compact('session_count','unique_vistors','user_count','registered_users','user_orders','devices'));
    })->name('dashboard');


    //User Management
    //Route::get('/registered/users', [StatisticsController::class, 'all_users'])->name('registered_users');
    Route::resource('users',UserController::class);
    Route::get('/activate/user/{id}', [StatisticsController::class, 'activate_user'])->name('users.activate');
    Route::put('/profile-photo/user', [StatisticsController::class, 'user_photo'])->name('user.photo');

    //Device(MCTS) Management
    Route::resource('device',DeviceController::class);
    Route::get('/new/orders/user', [StatisticsController::class, 'device_orders'])->name('user.orders');
    Route::delete('/delete/orders/{id}', [StatisticsController::class, 'destroy_orders'])->name('order.destroy');
    Route::get('/activate/device/{id}', [MapsController::class, 'activate_device'])->name('device.active');

    //Maps Management
    Route::get('/this/my/location/user', [StatisticsController::class, 'my_location'])->name('my.location');
    Route::get('/trip/history/{id}', [MapsController::class, 'trip_history'])->name('trip.history');
    Route::resource('locations',LocationController::class);
    Route::post('/geojson', [MapsController::class, 'storeGeofence'])->name('geojson.store');
    Route::post('/device/geofence', [MapsController::class, 'sendNotification'])->name('geofence.alert');
    Route::post('/send-sms', [MapsController::class, 'sendSMS'])->name('send.sms');
    Route::post('/devices/location', [MapsController::class, 'updateDeviceCoordinates'])->name('device.location');
    //test route
    //Route::get('/dev/location', [MapsController::class, 'updateDeviceCoordinates'])->name('dev.location');

    Route::get('/marker', [DeviceController::class, 'marker'])->name('current.marker');
    Route::delete('/delete/geofence/{id}', [MapsController::class, 'destroyGeofence']);

    //job on Queue to check geofences even when offline or on another page
    Route::get('/automap', function () {
        RunBladeFileJob::dispatch()->onQueue('default');
        //return redirect()->route('leaflet_maps.automap');
    });
    
    
});

