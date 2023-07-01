<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Location;
use Illuminate\Support\Facades\Log;

class TripHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trip:history';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trip History is to enable the system store coordinates to a file directory for every 24 hours for every device user.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $coord = Location::get();
        $nowDate = Carbon::now();

        //loop through all the time of the created_at column so the acquire new values every 24 hours
        foreach($coord as $location) {
            $createdAt = $location->created_at;
            $createdAt = Carbon::parse($createdAt);
        
            if ($createdAt != null && $nowDate->diffInHours($createdAt) >= 24) {
                Location::updateOrInsert(['id' => $location->id], [
                    'created_at' => $nowDate
                ]);
            } else {
                $location->created_at = $nowDate;
                $location->save();
                \Log::info('Now Date: ' . $nowDate);
            }
        }
    }
}