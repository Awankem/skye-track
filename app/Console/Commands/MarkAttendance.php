<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Intern;
use App\Models\ScannedDevices;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MarkAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mark:attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marks an intern as present';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $today = now('Africa/Lagos');
        if ($today->isMonday() || $today->isSunday()) {
            $this->info('Attendance marking skipped on Sunday and Monday.');
            return;
        }


        $devices = ScannedDevices::all();

        foreach ($devices as $device) {
            $intern = Intern::where('mac_address', $device->mac_address)->first();

            if ($intern) {
                Attendance::updateOrCreate(
                    [
                        'intern_id' => $intern->id,
                        'date' => $today->toDateString(),
                    ],
                    [
                        'sign_in' => $device->first_seen_at,
                        'sign_out' => $device->last_seen_at,
                        'status' => 'present',
                    ]
                );
            }
            Log::info($intern);
        }


        $this->info('Daily attendance updated.');
    }

}





// 1. If an intern does not login to the network between 9am and 4pm mark him as absent
