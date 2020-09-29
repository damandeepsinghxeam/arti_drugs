<?php

namespace App\Exports;

use App\Project;
use App\SalarySheet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class SalarySheetExport implements FromView
{
    protected $year;
    protected $month;
//    protected $project;
//    protected $department;
//    protected $paidNotPaid;

    protected $salarySheets;
    protected $projectEarningHeads;
    protected $projectDeductionHeads;

    public function __construct($salarySheets, $projectEarningHeads, $projectDeductionHeads, $year, $month)
    {
        $this->year = $year;
        $this->month = $month;
        $this->salarySheets = $salarySheets;
        $this->projectEarningHeads = $projectEarningHeads;
        $this->projectDeductionHeads = $projectDeductionHeads;

    }
    /**
    * @return \Illuminate\Support\Collection
    */

    public function view(): View
    {
        $year = $this->year;
        $month = $this->month;
        $salarySheets = $this->salarySheets;
        $projectEarningHeads = $this->projectEarningHeads;
        $projectDeductionHeads = $this->projectDeductionHeads;
        return view('salary_sheet.export', compact('salarySheets', 'projectEarningHeads', 'projectDeductionHeads', 'year', 'month'));
    }
}
