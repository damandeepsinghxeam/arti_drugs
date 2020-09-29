<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ConsolidatedAttendanceExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStrictNullComparison
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
            'Department',
            'Employee Name',
            'Employee Code',
            'On Date',
            'Holidays',
            'Week-Offs',
            'Workdays',
            'Late',
            'Absent Days',
            'Travel Days',
            'Paid Leaves',
            'Unpaid Leaves',
            'Total Paid Days',
            'Remarks'
        ];
    }
}
