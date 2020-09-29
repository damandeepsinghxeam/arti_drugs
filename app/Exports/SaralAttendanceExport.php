<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class SaralAttendanceExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStrictNullComparison
{
    protected $employees;

    public function __construct($employees)
    {
        $this->employees = $employees;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->employees;
    }

    public function headings(): array
    {
        return [
            '#',
            'Employee Name',
            'Employee Code',
            'Paid Leaves',
            'Unpaid Days',  // (Unpaid Leaves + Absent Days)
        ];
    }
}
