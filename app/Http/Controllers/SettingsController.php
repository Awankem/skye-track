<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index()
    {
        // Get current settings from cache or config
        $workingHoursStart = Cache::get('working_hours_start', '09:00');
        $workingHoursEnd = Cache::get('working_hours_end', '17:00');
        $lateThreshold = Cache::get('late_threshold', '09:00');
        $workingDays = Cache::get('working_days', ['tuesday', 'wednesday', 'thursday', 'friday', 'saturday']);
        
        // Get all departments
        $departments = Intern::select('department')->distinct()->pluck('department')->sort()->values();
        
        // Get system statistics
        $totalInterns = Intern::count();
        $totalDepartments = $departments->count();
        $totalAttendanceRecords = DB::table('attendances')->count();

        return view('settings.index', compact(
            'workingHoursStart',
            'workingHoursEnd',
            'lateThreshold',
            'workingDays',
            'departments',
            'totalInterns',
            'totalDepartments',
            'totalAttendanceRecords'
        ));
    }

    public function update(Request $request)
    {
        // Validate based on what's being updated
        if ($request->has('late_threshold') && !$request->has('working_hours_start')) {
            // Only late threshold is being updated
            $request->validate([
                'late_threshold' => 'required|date_format:H:i',
            ]);
            
            Cache::put('late_threshold', $request->late_threshold, now()->addYears(1));
            
            return redirect()->route('settings.index')
                ->with('success', 'Late arrival threshold updated to ' . $request->late_threshold . '! All reports and dashboards will use this new threshold immediately.');
        }
        
        // Full settings update
        $request->validate([
            'working_hours_start' => 'required|date_format:H:i',
            'working_hours_end' => 'required|date_format:H:i|after:working_hours_start',
            'late_threshold' => 'required|date_format:H:i',
            'working_days' => 'required|array',
            'working_days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
        ]);

        // Store settings in cache (in production, you'd use database)
        Cache::put('working_hours_start', $request->working_hours_start, now()->addYears(1));
        Cache::put('working_hours_end', $request->working_hours_end, now()->addYears(1));
        Cache::put('late_threshold', $request->late_threshold, now()->addYears(1));
        Cache::put('working_days', $request->working_days, now()->addYears(1));

        $message = 'Settings updated successfully! ';
        if ($request->has('late_threshold')) {
            $message .= 'Late arrival threshold is now set to ' . $request->late_threshold . '. All reports and dashboards will use this new threshold immediately.';
        }

        return redirect()->route('settings.index')
            ->with('success', $message);
    }

    public function addDepartment(Request $request)
    {
        $request->validate([
            'department' => 'required|string|max:255',
        ]);

        // This is just for display - actual departments come from interns
        return redirect()->route('settings.index')
            ->with('info', 'Department will be added when an intern with this department is created.');
    }
}

