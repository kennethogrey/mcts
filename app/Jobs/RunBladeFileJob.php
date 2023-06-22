<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;
use App\Models\Device;
use App\Models\Location;
use App\Models\User;
use Carbon\Carbon;
use App\Models\GeoFence;

class RunBladeFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $device = Device::with('geofences','coordinates')->where('status', 1)->get();
        $data = [
            'device' => $device,
        ];
        \Log::info("The Job ran Successfully!");
        $content = View::make('leaflet_maps.automap', $data)->render();
    }
}
