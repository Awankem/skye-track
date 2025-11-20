<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Intern;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SuperAdminSeeder::class);

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);







        $interns = [
            [
                'name' => 'Intern 1',
                'email' => 'intern1@example.com',
                'department' => 'Frontend',
                'mac_address' => '28:d0:43:7f:e6:25',
            ],
            [
                'name' => 'Intern 2',
                'email' => 'intern2@example.com',
                'department' => 'Backend',
                'mac_address' => '74:24:9f:d1:c3:ec',
            ],
            [
                'name' => 'Intern 3',
                'email' => 'intern3@example.com',
                'department' => 'Backend',
                'mac_address' => 'c2:c7:ae:6e:85:78',
            ],
            [
                'name' => 'Intern 4',
                'email' => 'intern4@example.com',
                'department' => 'Data Science',
                'mac_address' => '96:27:0b:4b:2e:a4',
            ],
            [
                'name' => 'Intern 5',
                'email' => 'intern5@example.com',
                'department' => 'UI/UX',
                'mac_address' => '6c:c7:ec:86:b7:50',
            ],
            [
                'name' => 'Intern 6',
                'email' => 'intern6@example.com',
                'department' => 'Networking',
                'mac_address' => '74:e5:0b:d7:f1:bc',
            ],
            [
                'name' => 'Intern 7',
                'email' => 'intern7@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '7c:76:35:f7:5b:34',
            ],
            [
                'name' => 'Intern 8',
                'email' => 'intern8@example.com',
                'department' => 'Frontend',
                'mac_address' => '66:6b:3c:6a:e4:fe',
            ],
            [
                'name' => 'Intern 9',
                'email' => 'intern9@example.com',
                    'department' => 'Frontend',
                    'mac_address' => '26:ff:d8:a2:b6:f1',
            ],
            [
                'name' => 'Intern 10',
                'email' => 'intern10@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '1c:ce:51:bc:f2:2f',
            ],
            [
                'name' => 'Intern 11',
                'email' => 'intern11@example.com',
                    'department' => 'Backend',
                    'mac_address' => '86:17:03:c2:78:ad',
            ],
            [
                'name' => 'Intern 12',
                'email' => 'intern12@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => 'e0:d4:e8:bc:e2:8d',
            ],
            [
                'name' => 'Intern 13',
                'email' => 'intern13@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => 'd2:c3:ae:06:db:f4',
            ],
            [
                'name' => 'Intern 14',
                'email' => 'intern14@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '38:ba:f8:e6:49:98',
            ],
            [
                'name' => 'Intern 15',
                'email' => 'intern15@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => 'a4:02:b9:25:c9:07',
            ],
            [
                'name' => 'Intern 16',
                'email' => 'intern16@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => 'ca:2e:15:39:03:fb',
            ],
            [
                'name' => 'Intern 17',
                'email' => 'intern17@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => 'f8:34:41:31:26:b7',
            ],
            [
                'name' => 'Intern 18',
                'email' => 'intern18@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '88:b1:11:85:7a:cd',
            ],
            [
                'name' => 'Intern 19',
                'email' => 'intern19@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '14:ab:c5:c3:ec:22',
            ],
            [
                'name' => 'Intern 20',
                'email' => 'intern20@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => 'a0:51:0b:99:fe:b2',
            ],
            [
                'name' => 'Intern 21',
                'email' => 'intern21@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '38:00:25:99:0f:1b',
            ],
            [
                'name' => 'Intern 22',
                'email' => 'intern22@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '5c:51:4f:3e:b6:dd',
            ],
            [
                'name' => 'Intern 23',
                'email' => 'intern23@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '7e:37:4c:37:37:e0',
            ],
            [
                'name' => 'Intern 24',
                'email' => 'intern24@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '0e:45:48:f9:f8:98',
            ],
            [
                'name' => 'Intern 25',
                'email' => 'intern25@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '26:5f:88:a6:c7:ef',
            ],
            [
                'name' => 'Intern 26',
                'email' => 'intern26@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '34:02:86:8a:ac:46',
            ],
            [
                'name' => 'Intern 27',
                'email' => 'intern27@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '9e:06:5c:0a:d4:90',
            ],
            [
                'name' => 'Intern 28',
                'email' => 'intern28@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '7e:e0:fc:20:dd:59',
            ],
            [
                'name' => 'Intern 29',
                'email' => 'intern29@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '94:53:30:13:77:65',
            ],
            [
                'name' => 'Intern 30',
                'email' => 'intern30@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '74:d8:3e:42:46:90',
            ],
            [
                'name' => 'Intern 31',
                'email' => 'intern31@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '96:a8:6e:de:43:2e',
            ],
            [
                'name' => 'Intern 32',
                'email' => 'intern32@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => 'c8:17:39:cc:61:66',
            ],
            [
                'name' => 'Intern 33',
                'email' => 'intern33@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '7c:76:35:0b:a8:ba',
            ],
            [
                'name' => 'Intern 34',
                'email' => 'intern34@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '96:6a:6a:da:0d:67',
            ],
            [
                'name' => 'Intern 35',
                'email' => 'intern35@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '68:54:5a:6b:f9:a4',
            ],
            [
                'name' => 'Intern 36',
                'email' => 'intern36@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '54:13:79:6e:05:2b',
            ],
            [
                'name' => 'Intern 37',
                'email' => 'intern37@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => 'b4:6b:fc:d0:87:ac',
            ],
            [
                'name' => 'Intern 38',
                'email' => 'intern38@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '80:19:34:23:cd:2d',
            ],
            [
                'name' => 'Intern 39',
                'email' => 'intern39@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => 'a0:a4:c5:a4:00:06',
            ],
            [
                'name' => 'Intern 40',
                'email' => 'intern40@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => 'e4:b3:18:f3:e8:91',
            ],
            [
                'name' => 'Intern 41',
                'email' => 'intern41@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => 'd4:3a:2c:b3:ea:79',
            ],
            [
                'name' => 'Intern 42',
                'email' => 'intern42@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => 'a0:51:0b:99:fe:b2',
            ],
            [
                'name' => 'Intern 43',
                'email' => 'intern43@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '78:2b:46:a2:e1:94',
            ],
            [
                'name' => 'Intern 44',
                'email' => 'intern44@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '06:03:56:19:c4:16',
            ],
            [
                'name' => 'Intern 45',
                'email' => 'intern45@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '60:f2:62:1b:d9:1f',
            ],
            [
                'name' => 'Intern 46',
                'email' => 'intern46@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '7e:f9:1d:73:74:73',
            ],
            [
                'name' => 'Intern 47',
                'email' => 'intern47@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => 'c8:3d:d4:f1:be:41',
            ],
            [
                'name' => 'Intern 48',
                'email' => 'intern48@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => 'b6:cc:31:b5:17:36',
            ],
            [
                'name' => 'Intern 49',
                'email' => 'intern49@example.com',
                'department' => 'Computer Engineering',
                'mac_address' => '78:0c:b8:20:a7:b5',
            ],
        ];

        foreach ($interns as $intern) {
            Intern::create($intern);
        }



        // Get all intern IDs. Seeder will not run if there are no interns.
        $internIds = Intern::pluck('id');

        if ($internIds->isEmpty()) {
            $this->command->info('No interns found. Skipping Attendance seeder.');
            return;
        }

        $this->command->info('Seeding attendance records for 4 weeks...');

        // Define the start date. We'll start from 4 weeks ago from today.
        $startDate = Carbon::now()->subWeeks(4)->startOfWeek(Carbon::TUESDAY);

        // Loop for 4 weeks
        for ($week = 0; $week < 4; $week++) {
            // Loop from Tuesday (day 2) to Saturday (day 6)
            for ($day = 0; $day < 5; $day++) {
                $currentDate = $startDate->copy()->addWeeks($week)->addDays($day);

                // Seed attendance for each intern on the current day
                foreach ($internIds as $internId) {
                    // Randomly decide if an intern is present or absent
                    $status = (rand(1, 10) > 2) ? 'present' : 'absent'; // 80% chance of being present

                    $signInTime = null;
                    $signOutTime = null;

                    if ($status === 'present') {
                        // Generate a random sign-in time between 8:00 AM and 9:30 AM
                        $signInHour = rand(8, 9);
                        $signInMinute = ($signInHour == 9) ? rand(0, 30) : rand(0, 59);
                        $signInTime = $currentDate->copy()->setTime($signInHour, $signInMinute, rand(0, 59));

                        // Generate a random sign-out time between 4:00 PM and 5:30 PM
                        $signOutHour = rand(16, 17);
                        $signOutMinute = ($signOutHour == 17) ? rand(0, 30) : rand(0, 59);
                        $signOutTime = $currentDate->copy()->setTime($signOutHour, $signOutMinute, rand(0, 59));
                    }

                    Attendance::create([
                        'intern_id' => $internId,
                        'status'    => $status,
                        'date'      => $currentDate->toDateString(),
                        'sign_in'   => $signInTime,
                        'sign_out'  => $signOutTime,
                    ]);
                }
            }
        }

        $this->command->info('Attendance seeding completed successfully.');





    }
}





        