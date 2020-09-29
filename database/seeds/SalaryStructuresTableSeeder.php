<?php

use Illuminate\Database\Seeder;
use App\SalaryStructure;

class SalaryStructuresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
//        			['name'=>'Xeam HO'],
//        			['name'=>'Lehri HO']

        		];

        foreach ($data as $key => $value) {
			SalaryStructure::create($value);
		}
    }
}
