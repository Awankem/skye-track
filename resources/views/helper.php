<?php

use App\Models\Attendance;
use App\Models\Intern;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;



// Dashboard Data

// Helper function to get late threshold time
function getLateThreshold()
{
    $threshold = Cache::get('late_threshold', '09:00');
    $time = explode(':', $threshold);
    return ['hour' => (int)$time[0], 'minute' => (int)$time[1]];
}

// Helper function to get working days
function getWorkingDays()
{
    return Cache::get('working_days', ['tuesday', 'wednesday', 'thursday', 'friday', 'saturday']);
}

// number of interns
function countIntern()
{
    return Intern::count();
}

// Number of Departments Tracked
function countDepartmentsTracked()
{
    return Intern::distinct('department')->count('department');
}

// Names of Departments Tracked
function getDistinctDepartments()
{
    return Intern::select('department')->distinct()->pluck('department');
}







function averageDailyAttendance()
{
    $totalInterns = countIntern();

    if ($totalInterns === 0) {
        return 0;
    }

    $attendanceByDay = Attendance::where('status', 'present')
        ->select(DB::raw('DATE(date) as attendance_date'), DB::raw('count(*) as present_count'))
        ->groupBy('attendance_date')
        ->get();

    if ($attendanceByDay->isEmpty()) {
        return 0;
    }


    $dailyPercentages = $attendanceByDay->map(function ($day) use ($totalInterns) {
        return ($day->present_count / $totalInterns) * 100;
    });

    return round($dailyPercentages->avg());
}




// function eachDayAttendance()
// {
//     $attendanceByDay = Attendance::where('status', 'present')
//         ->select(DB::raw('DATE(date) as attendance_date'), DB::raw('count(*) as present_count'))
//         ->groupBy('attendance_date')
//         ->get();

//     return $attendanceByDay->mapWithKeys(function ($day) {
//         return [$day->attendance_date => $day->present_count];
//     });
// }

function getDailyAttendanceTrendData()
{
    $workingDays = getWorkingDays();
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

    $attendanceByDay = Attendance::where('status', 'present')
        ->where('date', '>=', Carbon::now()->subDays(6))
        ->select(DB::raw('DATE(date) as attendance_date'), DB::raw('count(*) as present_count'))
        ->groupBy('attendance_date')
        ->orderBy('attendance_date', 'asc')
        ->get();

    $chartData = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::now()->subDays($i);
        // Only include working days
        if (!in_array($date->dayOfWeek, $workingDayNumbers)) {
            continue;
        }
        $dateString = $date->format('Y-m-d');
        $dayLabel = $date->format('D') . " " . $dateString;
        $attendance = $attendanceByDay->firstWhere('attendance_date', $dateString);
        $chartData[$dayLabel] = $attendance ? $attendance->present_count : 0;
    }

    return json_encode([
        'labels' => array_keys($chartData),
        'data' => array_values($chartData),
    ]);
}

function getDepartmentalAttendanceData()
{
    $departments = Intern::select('department')->distinct()->pluck('department');
    $data = [];

    foreach ($departments as $department) {
        $total = Intern::where('department', $department)->count();
        $present = Attendance::where('status', 'present')
            ->where('date', '=', Carbon::now()->format('Y-m-d'))
            ->whereHas('intern', function ($query) use ($department) {
                $query->where('department', $department);
            })
            ->count();

        $data[] = [
            'name' => $department,
            'present' => $present,
            'total' => $total,
            'width' => ($total > 0) ? ($present / $total) * 100 : 0,
        ];
    }

    return $data;

}



function getTodayDepartmentalChartData()
{
    $departments = Intern::select('department')->distinct()->pluck('department');
    $chartData = [];

    foreach ($departments as $department) {
        $present = Attendance::where('status', 'present')
            ->where('date', '=', Carbon::now()->format('Y-m-d'))
            ->whereHas('intern', function ($query) use ($department) {
                $query->where('department', $department);
            })
            ->count();
        $chartData[$department] = $present;
    }

    return json_encode([
        'labels' => array_keys($chartData),
        'datasets' => [
            [
                'label' => 'Present Interns',
                'data' => array_values($chartData),
                'backgroundColor' => '#10b981',
            ]
        ],
    ]);
}




function getAttendanceIncrease()
{
    $today = Carbon::today();
    $workingDays = getWorkingDays();
    
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

    // Only calculate if today is a working day
    if (!in_array($today->dayOfWeek, $workingDayNumbers)) {
        return '0%';
    }

    $todayCount = Attendance::where('status', 'present')
        ->whereDate('date', $today)
        ->count();

    // Find the previous working day
    $previousWorkingDay = $today->copy()->subDay();
    $maxDaysBack = 7; // Safety limit
    $daysBack = 0;
    
    while ($daysBack < $maxDaysBack && !in_array($previousWorkingDay->dayOfWeek, $workingDayNumbers)) {
        $previousWorkingDay->subDay();
        $daysBack++;
    }

    // If we couldn't find a previous working day, return 0
    if ($daysBack >= $maxDaysBack || !in_array($previousWorkingDay->dayOfWeek, $workingDayNumbers)) {
        return $todayCount > 0 ? '+100%' : '0%';
    }

    $yesterdayCount = Attendance::where('status', 'present')
        ->whereDate('date', $previousWorkingDay)
        ->count();

    if ($yesterdayCount > 0) {
        $increase = (($todayCount - $yesterdayCount) / $yesterdayCount) * 100;
    } elseif ($todayCount > 0) {
        $increase = 100;
    } else {
        $increase = 0;
    }

    if (round($increase) > 0) {
        return '+' . round($increase) . '%';
    } elseif (round($increase) < 0) {
        return round($increase) . '%'; // Negative already has minus sign
    } else {
        return round($increase) . '%';
    }
}




function getPresentAbsentLateData()
{
    $today = Carbon::today();

    $totalInterns = countIntern();

    // Get today's attendance using the date field, not created_at
    $todaysAttendance = Attendance::whereDate('date', $today)->get();

    $presentCount = $todaysAttendance->where('status', 'present')->count();

    $threshold = getLateThreshold();
    $lateCount = $todaysAttendance->where('status', 'present')
        ->filter(function ($attendance) use ($today, $threshold) {
            if (!$attendance->sign_in) {
                return false;
            }
            $signInTime = Carbon::parse($attendance->sign_in);
            $thresholdTime = $today->copy()->setTime($threshold['hour'], $threshold['minute'], 0);
            return $signInTime->gt($thresholdTime);
        })
        ->count();

    $absentCount = $totalInterns - $presentCount;

    $chartData = [
        'labels' => ['Present', 'Absent', 'Late'],
        'data'   => [$presentCount, $absentCount, $lateCount],
    ];

    return json_encode($chartData);
}



function getLateComersByDepartment()
{
    $today = Carbon::today();
    $threshold = getLateThreshold();
    $thresholdTime = $today->copy()->setTime($threshold['hour'], $threshold['minute'], 0);

    $departments = Intern::select('department')->distinct()->pluck('department');
    $chartData = [];
    foreach ($departments as $department) {
        $lateCount = Attendance::where('status', 'present')
            ->whereDate('date', $today)
            ->whereHas('intern', function ($query) use ($department) {
                $query->where('department', $department);
            })
            ->get()
            ->filter(function ($attendance) use ($thresholdTime) {
                if (!$attendance->sign_in) {
                    return false;
                }
                $signInTime = Carbon::parse($attendance->sign_in);
                return $signInTime->gt($thresholdTime);
            })
            ->count();

        $chartData[$department] = $lateCount;
    }
    return json_encode(
        [
            'labels' => array_keys($chartData),
            'data' => array_values($chartData),
        ]
    );
}

    




function getWeeklyAttendanceFor4Weeks(){
    $attendanceData = [];
    $today = Carbon::today();
    $totalInterns = countIntern();
    $workingDays = getWorkingDays();
    
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

    for ($i = 0; $i < 4; $i++) {
        $weekStart = $today->copy()->subWeeks($i)->startOfWeek();
        $weekEnd = $today->copy()->subWeeks($i)->endOfWeek();

        // Count working days in the week
        $workingDaysInWeek = 0;
        $currentDay = $weekStart->copy();
        while ($currentDay->lte($weekEnd)) {
            if (in_array($currentDay->dayOfWeek, $workingDayNumbers)) {
                $workingDaysInWeek++;
            }
            $currentDay->addDay();
        }

        $presentCount = Attendance::where('status', 'present')
            ->whereBetween('date', [$weekStart, $weekEnd])
            ->count();

        // Calculate percentage: (present days) / (total interns * working days in week) * 100
        $expectedDays = $totalInterns * $workingDaysInWeek;
        $percentage = $expectedDays > 0 ? round(($presentCount / $expectedDays) * 100, 1) : 0;
        
        $attendanceData[] = $percentage;
    }

    return json_encode([
        'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        'data' => array_reverse($attendanceData), // Reverse to show oldest week first
    ]);
}





// Intern Data
function totalDays($id){
    $attendanceCount = Attendance::where('intern_id', $id)
        ->count();
    return $attendanceCount;
}


function presentDays($id){
    $presentCount = Attendance::where('intern_id', $id)
        ->where('status', 'present')
        ->count();
    return $presentCount;
}

function absentDays($id){
    $absentCount = Attendance::where('intern_id', $id)
        ->where('status', 'absent')
        ->count();
    return $absentCount;
}

function calculateDuration($timeIn, $timeOut)
{
        if ($timeIn && $timeOut) {
            $start = Carbon::parse($timeIn);
            $end = Carbon::parse($timeOut);
            return round($end->diffInHours($start));
        }
        return 0;
}
