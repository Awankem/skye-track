<?php

namespace App\Console\Commands;

use App\Models\ScannedDevices;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ScanDevices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'devices:scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scans the network for connected devices';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now('Africa/Lagos');
        
        // Get working days from settings
        $workingDays = Cache::get('working_days', ['tuesday', 'wednesday', 'thursday', 'friday', 'saturday']);
        $dayMap = [
            'monday' => Carbon::MONDAY,
            'tuesday' => Carbon::TUESDAY,
            'wednesday' => Carbon::WEDNESDAY,
            'thursday' => Carbon::THURSDAY,
            'friday' => Carbon::FRIDAY,
            'saturday' => Carbon::SATURDAY,
            'sunday' => Carbon::SUNDAY,
        ];
        $workingDayNumbers = array_map(function($day) use ($dayMap) {
            return $dayMap[strtolower($day)] ?? null;
        }, $workingDays);
        $workingDayNumbers = array_filter($workingDayNumbers);
        
        $dayName = strtolower($today->format('l'));
        
        if (!in_array($dayName, $workingDays)) {
            $this->info("Scan skipped. {$dayName} is not a working day.");
            return;
        }
       
        $devices = shell_exec('arp-scan --localnet');

        // $devices = shell_exec('arp -a');

        preg_match_all('/([0-9a-fA-F:]{17})/', $devices, $matches);
        $macs = $matches[1]; // MAC addresses

        Log::info('Detected MAC addresses:', $macs);

        $now = Carbon::now('Africa/Lagos');
        
        foreach ($macs as $mac) {
            $device = ScannedDevices::where('mac_address', $mac)->first();

            if ($device) {
                // Update last_seen_at if device already exists
                // Only update first_seen_at if it's the first time today
                $deviceDate = $device->first_seen_at ? Carbon::parse($device->first_seen_at)->format('Y-m-d') : null;
                $todayDate = $now->format('Y-m-d');
                
                if ($deviceDate !== $todayDate) {
                    // New day, reset first_seen_at
                    $device->update([
                        'first_seen_at' => $now,
                        'last_seen_at' => $now
                    ]);
                } else {
                    // Same day, just update last_seen_at
                    $device->update([
                        'last_seen_at' => $now
                    ]);
                }
            } else {
                // New device, set both first and last seen
                ScannedDevices::create([
                    'mac_address'   => $mac,
                    'first_seen_at' => $now,
                    'last_seen_at'  => $now
                ]);
            }
        }

        $this->info('Scan completed. Devices updated.');
    }
}
