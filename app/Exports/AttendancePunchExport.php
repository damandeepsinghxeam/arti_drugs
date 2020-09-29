<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class AttendancePunchExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStrictNullComparison
{
    protected $punches;

    public function __construct($punches)
    {
        $this->punches = $punches;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->punches;
    }

    public function headings(): array
    {
        return [
            '#',
            'Employee Code',
            'Designation',
            'Employee Name',
            'On Date',
            'Punch Count',
            'First',
            'Second',
            'Third',
            'Fourth',
            'Fifth',
            'Sixth',
            'Seventh',
            'Last'
        ];
    }
}
