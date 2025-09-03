<?php

namespace App\Exports;

use App\Models\Intern;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InternsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Intern::select('ID',
            'Name',
            'Email',
            'Department',
            'Mac_Address')->get();
    }
    public function headings(): array
    {
        return [
            'S/N',
            'Name',
            'Email',
            'Department',
            'Mac Address',
        ];
    }
}
