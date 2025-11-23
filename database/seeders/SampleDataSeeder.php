<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Intern;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    /**
     * Seed sample data: 50 interns across 5 departments with 2 months of attendance.
     */
    public function run(): void
    {
        $this->command->info('Creating 50 interns across 5 departments...');

        // Departments distribution (10 interns per department)
        $departments = ['Frontend', 'Backend', 'UI/UX', 'Data Science', 'Mobile'];
        
        // Sample first and last names for realistic data
        $firstNames = [
            'John', 'Jane', 'Michael', 'Sarah', 'David', 'Emily', 'James', 'Jessica', 'Robert', 'Amanda',
            'William', 'Melissa', 'Richard', 'Nicole', 'Joseph', 'Michelle', 'Thomas', 'Kimberly', 'Charles', 'Ashley',
            'Daniel', 'Jennifer', 'Matthew', 'Lisa', 'Anthony', 'Angela', 'Mark', 'Stephanie', 'Donald', 'Rebecca',
            'Steven', 'Laura', 'Paul', 'Sharon', 'Andrew', 'Cynthia', 'Joshua', 'Kathleen', 'Kenneth', 'Amy',
            'Kevin', 'Angela', 'Brian', 'Brenda', 'George', 'Emma', 'Edward', 'Olivia', 'Ronald', 'Sophia'
        ];

        $lastNames = [
            'Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez',
            'Hernandez', 'Lopez', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin', 'Lee',
            'Thompson', 'White', 'Harris', 'Sanchez', 'Clark', 'Ramirez', 'Lewis', 'Robinson', 'Walker', 'Young',
            'Allen', 'King', 'Wright', 'Scott', 'Torres', 'Nguyen', 'Hill', 'Flores', 'Green', 'Adams',
            'Nelson', 'Baker', 'Hall', 'Rivera', 'Campbell', 'Mitchell', 'Carter', 'Roberts', 'Gomez', 'Phillips'
        ];

        // Clear existing interns and attendance (optional - comment out if you want to keep existing data)
        // Attendance::truncate();
        // Intern::truncate();

        $interns = [];
        $internCounter = 1;
        $usedMacAddresses = [];

        // Create 50 interns (10 per department)
        foreach ($departments as $department) {
            for ($i = 0; $i < 10; $i++) {
                $firstName = $firstNames[($internCounter - 1) % count($firstNames)];
                $lastName = $lastNames[($internCounter - 1) % count($lastNames)];
                
                // Generate unique MAC address
                do {
                    $macAddress = sprintf(
                        '%02x:%02x:%02x:%02x:%02x:%02x',
                        rand(0, 255),
                        rand(0, 255),
                        rand(0, 255),
                        rand(0, 255),
                        rand(0, 255),
                        rand(0, 255)
                    );
                } while (in_array($macAddress, $usedMacAddresses));
                
                $usedMacAddresses[] = $macAddress;

                // Ensure unique email by adding counter if needed
                $baseEmail = strtolower($firstName . '.' . $lastName);
                $email = $baseEmail . '@skyeintern.com';
                $emailCounter = 1;
                
                while (Intern::where('email', $email)->exists()) {
                    $email = $baseEmail . $emailCounter . '@skyeintern.com';
                    $emailCounter++;
                }

                $interns[] = Intern::create([
                    'name' => $firstName . ' ' . $lastName,
                    'email' => $email,
                    'department' => $department,
                    'mac_address' => $macAddress,
                ]);

                $internCounter++;
            }
        }

        $this->command->info('50 interns created successfully!');
        $this->command->info('Seeding 2 months of attendance data...');

        // Get all intern IDs
        $internIds = Intern::pluck('id')->toArray();

        // Calculate date range: 2 months back from today
        $endDate = Carbon::today();
        $startDate = Carbon::today()->subMonths(2)->startOfWeek(Carbon::TUESDAY);

        // Working days: Tuesday to Saturday
        $workingDays = [Carbon::TUESDAY, Carbon::WEDNESDAY, Carbon::THURSDAY, Carbon::FRIDAY, Carbon::SATURDAY];

        $totalDays = 0;
        $attendanceCount = 0;

        // Loop through each day from start to end
        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            // Only create attendance for working days (Tuesday to Saturday)
            if (in_array($currentDate->dayOfWeek, $workingDays)) {
                foreach ($internIds as $internId) {
                    // Realistic attendance patterns:
                    // - 85% chance of being present (higher than before for better graphs)
                    // - Some interns have better attendance than others
                    $attendanceChance = rand(1, 100);
                    $status = ($attendanceChance <= 85) ? 'present' : 'absent';

                    $signInTime = null;
                    $signOutTime = null;

                    if ($status === 'present') {
                        // Sign-in time: 70% arrive before 9:00, 30% arrive after (late)
                        $isLate = rand(1, 100) <= 30;
                        
                        if ($isLate) {
                            // Late arrival: between 9:00 AM and 10:30 AM
                            $signInHour = 9;
                            $signInMinute = rand(0, 90); // 0-90 minutes past 9 AM
                            if ($signInMinute >= 60) {
                                $signInHour = 10;
                                $signInMinute = $signInMinute - 60;
                            }
                        } else {
                            // On time: between 7:30 AM and 9:00 AM
                            $signInHour = rand(7, 8);
                            $signInMinute = ($signInHour == 7) ? rand(30, 59) : rand(0, 59);
                        }

                        $signInTime = $currentDate->copy()->setTime($signInHour, $signInMinute, rand(0, 59));

                        // Sign-out time: between 4:00 PM and 6:00 PM
                        $signOutHour = rand(16, 17);
                        $signOutMinute = ($signOutHour == 17) ? rand(0, 59) : rand(0, 59);
                        $signOutTime = $currentDate->copy()->setTime($signOutHour, $signOutMinute, rand(0, 59));

                        // Ensure sign-out is after sign-in
                        if ($signOutTime->lte($signInTime)) {
                            $signOutTime = $signInTime->copy()->addHours(rand(7, 9));
                        }
                    }

                    Attendance::create([
                        'intern_id' => $internId,
                        'status' => $status,
                        'date' => $currentDate->toDateString(),
                        'sign_in' => $signInTime,
                        'sign_out' => $signOutTime,
                    ]);

                    $attendanceCount++;
                }
                $totalDays++;
            }

            $currentDate->addDay();
        }

        $this->command->info("Attendance seeding completed!");
        $this->command->info("Created attendance records for {$totalDays} working days");
        $this->command->info("Total attendance records: {$attendanceCount}");
        $this->command->info("Date range: {$startDate->format('Y-m-d')} to {$endDate->format('Y-m-d')}");
    }
}

