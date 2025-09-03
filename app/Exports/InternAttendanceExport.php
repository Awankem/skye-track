<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InternAttendanceExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $internId;

    public function __construct($internId)
    {
        $this->internId = $internId;
    }

    public function collection()
    {
        return Attendance::where('intern_id', $this->internId)->select('id', 'date', 'status', 'sign_in', 'sign_out')->paginate(10);
    }

    public function headings(): array
    {
        return [
            'S/N',
            'Date',
            'Status',
            'Sign In',
            'Sign Out',
        ];
    }
}
