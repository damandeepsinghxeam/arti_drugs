<?php

namespace App\Imports;

use App\SalarySheet;
use Maatwebsite\Excel\Concerns\ToModel;

class SalarySheetImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SalarySheet([
            'total_month_days' => $row[0],
            'year' => $row[2],
            'month' => $row[3],
            'paid_days' => $row[4],
            'unpaid_days' => $row[5],
            'salary' => $row[6],
            'gross_salary' => $row[7]
        ]);
    }
}
