<?php

namespace App\Http\Controllers;

use App\Exports\InternAttendanceExport;
use App\Models\Intern;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    //export intern attendance
    public function export($internId)
    {
        $intern_name = Intern::find($internId)->name;
        return Excel::download(new InternAttendanceExport($internId), "{$intern_name}_attendance.csv",\Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }
}
