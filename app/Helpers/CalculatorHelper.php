<?php

namespace App\Helpers;
use App\Pf;
use App\Esi;

class CalculatorHelper
{

    public static function calculatePf($epfPercentage, $salary)
    {
        return ($epfPercentage / 100) * $salary;
    }

    public static function calculateEsi($salary, $employeePercentage, $employerPercentage)
    {
        $totalPercent = $employeePercentage+$employerPercentage;
        return ($totalPercent/100)*$salary;
    }
}
