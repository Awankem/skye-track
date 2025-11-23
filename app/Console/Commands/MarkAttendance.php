<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Intern;
use App\Models\ScannedDevices;
use Carbon\Carbon;
use Illuminate\Console\Command;

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
        
        // Get working days from settings
        $workingDays = setting('working_days', ['tuesday', 'wednesday', 'thursday', 'friday', 'saturday']);
        $dayName = strtolower($today->format('l'));
        
        if (!in_array($dayName, $workingDays)) {
            $this->info("Attendance marking skipped. {$dayName} is not a working day.");
            return;
        }

        // Get working hours from settings
        $workingHoursStart = setting('working_hours_start', '09:00');
        $workingHoursEnd = setting('working_hours_end', '17:00');
        
        $startParts = explode(':', $workingHoursStart);
        $endParts = explode(':', $workingHoursEnd);
        $startHour = (int)$startParts[0];
        $startMinute = (int)$startParts[1];
        $endHour = (int)$endParts[0];
        $endMinute = (int)$endParts[1];
        
        $workingStart = $today->copy()->setTime($startHour, $startMinute, 0);
        $workingEnd = $today->copy()->setTime($endHour, $endMinute, 0);

        // Get all scanned devices that were seen today
        // Check devices where first_seen_at or last_seen_at is today
        $scannedDevices = ScannedDevices::where(function($query) use ($today) {
                $query->whereDate('first_seen_at', $today->toDateString())
                      ->orWhereDate('last_seen_at', $today->toDateString());
            })
            ->get();

        $scannedMacAddresses = $scannedDevices->pluck('mac_address')->toArray();

        // Mark present for scanned devices
        foreach ($scannedDevices as $device) {
            $intern = Intern::where('mac_address', $device->mac_address)->first();

            if ($intern && $device->first_seen_at) {
                $signInTime = Carbon::parse($device->first_seen_at);
                
                // Mark as present if device was scanned (regardless of time)
                // Late status will be calculated based on late threshold in reports/dashboards
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
        }

        // Mark absent for interns not scanned today (only if we're past the working hours start)
        if ($today->gte($workingStart)) {
            $allInterns = Intern::all();
            
            foreach ($allInterns as $intern) {
                if (!in_array($intern->mac_address, $scannedMacAddresses)) {
                    // Check if attendance already exists for today
                    $existingAttendance = Attendance::where('intern_id', $intern->id)
                        ->whereDate('date', $today->toDateString())
                        ->first();
                    
                    // Only mark as absent if no attendance record exists
                    if (!$existingAttendance) {
                        Attendance::updateOrCreate(
                            [
                                'intern_id' => $intern->id,
                                'date' => $today->toDateString(),
                            ],
                            [
                                'status' => 'absent',
                                'sign_in' => null,
                                'sign_out' => null,
                            ]
                        );
                    }
                }
            }
        }

        $this->info('Daily attendance updated.');
    }

}





// 1. If an intern does not login to the network between 9am and 4pm mark him as absent
