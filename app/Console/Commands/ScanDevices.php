<?php

namespace App\Console\Commands;

use App\Models\ScannedDevices;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
        if ($today->isMonday() || $today->isSunday()) {
            $this->info('Scan skipped on Sunday and Monday.');
            return;
        }
       
        $devices = shell_exec('arp-scan --localnet');

        // $devices = shell_exec('arp -a');

        preg_match_all('/([0-9a-fA-F:]{17})/', $devices, $matches);
        $macs = $matches[1]; // MAC addresses

        Log::info('Detected MAC addresses:', $macs);

        foreach ($macs as $mac) {
            $device = ScannedDevices::where('mac_address', $mac)->first();

            if ($device) {
                $device->update([
                    'last_seen_at' => Carbon::now('Africa/Lagos')
                ]);
            } else {
                ScannedDevices::create([
                    'mac_address'   => $mac,
                    'first_seen_at' => Carbon::now('Africa/Lagos'),
                    'last_seen_at'  => Carbon::now('Africa/Lagos')
                ]);
            }
        }

        $this->info('Scan completed. Devices updated.');
    }
}
