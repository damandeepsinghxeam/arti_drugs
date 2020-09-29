<?php

use Illuminate\Database\Seeder;
use App\ProbationPeriod;

class ProbationPeriodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        			['name'=>'one month','no_of_days'=>30],
        			['name'=>'two months','no_of_days'=>60],
        			['name'=>'three months','no_of_days'=>90],
        			['name'=>'six months','no_of_days'=>180],
        			['name'=>'twelve months','no_of_days'=>365]        			
        		];

        foreach ($data as $key => $value) {
			ProbationPeriod::create($value);
		}
    }
}
