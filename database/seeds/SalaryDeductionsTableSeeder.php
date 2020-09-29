<?php

use Illuminate\Database\Seeder;
use App\SalaryDeduction;

class SalaryDeductionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
//                    'PF',
//                    'ESI'
        		];

        foreach ($data as $key => $value) {
		 	SalaryDeduction::create(['name' => $value]);
		}
    }
}
