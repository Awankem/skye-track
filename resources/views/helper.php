<?php

use App\Models\Attendance;
use App\Models\Intern;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


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
    $attendanceByDay = Attendance::where('status', 'present')
        ->where('date', '>=', Carbon::now()->subDays(6))
        ->select(DB::raw('DATE(date) as attendance_date'), DB::raw('count(*) as present_count'))
        ->groupBy('attendance_date')
        ->orderBy('attendance_date', 'asc')
        ->get();

    $chartData = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::now()->subDays($i);
        if ($date->isMonday() || $date->isSunday()) {
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

    // Only calculate for Tuesday to Saturday, as Sunday and Monday are non-working days.
    if ($today->isSunday() || $today->isMonday()) {
        return 0;
    }

    $todayCount = Attendance::where('status', 'present')
        ->whereDate('date', $today)
        ->count();

    // Determine the date of the previous working day for comparison.
    $previousWorkingDay = $today->copy();
    if ($today->isTuesday()) {
        // If today is Tuesday, the last working day was Saturday.
        $previousWorkingDay->subDays(3);
    } else {
        // For Wed, Thu, Fri, Sat, the last working day is simply the day before.
        $previousWorkingDay->subDay();
    }

    $yesterdayCount = Attendance::where('status', 'present')
        ->whereDate('date', $previousWorkingDay)
        ->count();

    if ($yesterdayCount > 0) {
        $increase = (($todayCount - $yesterdayCount) / $yesterdayCount) * 100;
    } elseif ($todayCount > 0) {
        // If yesterday had 0 attendance and today has some, it's a 100% increase.
        $increase = 100;
    } else {
        // If both are 0, there's no change.
        $increase = 0;
    }

    if (round($increase) > 0) {
        return '+' . round($increase) . '%';
    } elseif (round($increase) < 0) {
        return '-' . round($increase) . '%';
    } else {
        return round($increase) . '%';
    }
}




function getPresentAbsentLateData()
{
    $today = Carbon::today();

    $totalInterns = countIntern();

    $todaysAttendance = Attendance::whereDate('created_at', $today)->get();

    $presentCount = $todaysAttendance->where('status', 'present')->count();

    $lateCount = $todaysAttendance->where('status', 'present')
        ->where('sign_in', '>', $today->copy()->setTime(9, 0, 0))
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

    $departments = Intern::select('department')->distinct()->pluck('department');
    $chartData = [];
    foreach ($departments as $department) {
        $lateCount = Attendance::where('status', 'present')
            ->whereDate('date', $today)
            ->where('sign_in', '>', $today->copy()->setTime(9, 0, 0))
            ->whereHas('intern', function ($query) use ($department) {
                $query->where('department', $department);
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

    for ($i = 0; $i < 4; $i++) {
        $weekStart = $today->copy()->subWeeks($i)->startOfWeek();
        $weekEnd = $today->copy()->subWeeks($i)->endOfWeek();

        $presentCount = Attendance::where('status', 'present')
            ->whereBetween('date', [$weekStart, $weekEnd])
            ->count();

        $attendanceData[] = $presentCount;
    }

    return json_encode([
        'labels' => ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        'data' => $attendanceData,
    ]);
}