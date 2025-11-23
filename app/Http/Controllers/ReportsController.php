<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Intern;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        $department = $request->get('department', 'all');

        // Get attendance data based on filters
        $query = Attendance::whereBetween('date', [$startDate, $endDate]);

        if ($department !== 'all') {
            $query->whereHas('intern', function ($q) use ($department) {
                $q->where('department', $department);
            });
        }

        $attendances = $query->with('intern')->orderBy('date', 'desc')->paginate(50);

        // Summary statistics
        $totalPresent = Attendance::whereBetween('date', [$startDate, $endDate])
            ->where('status', 'present')
            ->when($department !== 'all', function ($q) use ($department) {
                $q->whereHas('intern', function ($query) use ($department) {
                    $query->where('department', $department);
                });
            })
            ->count();

        $totalAbsent = Attendance::whereBetween('date', [$startDate, $endDate])
            ->where('status', 'absent')
            ->when($department !== 'all', function ($q) use ($department) {
                $q->whereHas('intern', function ($query) use ($department) {
                    $query->where('department', $department);
                });
            })
            ->count();

        $lateThreshold = Cache::get('late_threshold', '09:00');
        $thresholdParts = explode(':', $lateThreshold);
        $thresholdHour = (int)$thresholdParts[0];
        $thresholdMinute = (int)$thresholdParts[1];
        
        // Get all attendances and filter by late threshold
        $totalLate = Attendance::whereBetween('date', [$startDate, $endDate])
            ->where('status', 'present')
            ->when($department !== 'all', function ($q) use ($department) {
                $q->whereHas('intern', function ($query) use ($department) {
                    $query->where('department', $department);
                });
            })
            ->get()
            ->filter(function ($attendance) use ($thresholdHour, $thresholdMinute) {
                if (!$attendance->sign_in) {
                    return false;
                }
                $signInTime = \Carbon\Carbon::parse($attendance->sign_in);
                $thresholdTime = $signInTime->copy()->setTime($thresholdHour, $thresholdMinute, 0);
                return $signInTime->gt($thresholdTime);
            })
            ->count();

        // Daily attendance trend
        $dailyTrend = Attendance::whereBetween('date', [$startDate, $endDate])
            ->where('status', 'present')
            ->when($department !== 'all', function ($q) use ($department) {
                $q->whereHas('intern', function ($query) use ($department) {
                    $query->where('department', $department);
                });
            })
            ->select(DB::raw('DATE(date) as attendance_date'), DB::raw('count(*) as count'))
            ->groupBy('attendance_date')
            ->orderBy('attendance_date', 'asc')
            ->get();

        // Department-wise statistics
        $departmentStats = Intern::select('department', DB::raw('count(*) as total'))
            ->groupBy('department')
            ->get()
            ->map(function ($dept) use ($startDate, $endDate) {
                $present = Attendance::whereBetween('date', [$startDate, $endDate])
                    ->where('status', 'present')
                    ->whereHas('intern', function ($q) use ($dept) {
                        $q->where('department', $dept->department);
                    })
                    ->count();
                
                return [
                    'department' => $dept->department,
                    'total' => $dept->total,
                    'present' => $present,
                    'percentage' => $dept->total > 0 ? round(($present / ($dept->total * Carbon::parse($startDate)->diffInDays($endDate) + 1)) * 100, 2) : 0
                ];
            });

        $departments = Intern::select('department')->distinct()->pluck('department');

        return view('reports.index', compact(
            'attendances',
            'startDate',
            'endDate',
            'department',
            'totalPresent',
            'totalAbsent',
            'totalLate',
            'dailyTrend',
            'departmentStats',
            'departments'
        ));
    }
}

