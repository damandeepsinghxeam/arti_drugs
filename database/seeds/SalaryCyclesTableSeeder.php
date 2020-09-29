<?php

use Illuminate\Database\Seeder;
use App\SalaryCycle;

class SalaryCyclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        			['name'=>'Monthly','salary_from'=>'2019-03-07','salary_to'=>'2019-04-07'],
        			['name'=>'Bi-Weekly','salary_from'=>'2019-03-07','salary_to'=>'2019-03-21'],
        			['name'=>'Weekly','salary_from'=>'2019-03-07','salary_to'=>'2019-03-14'],
        			['name'=>'Yearly','salary_from'=>'2019-03-07','salary_to'=>'2020-03-07']
        		];

        foreach ($data as $key => $value) {
			SalaryCycle::create($value);
		}
    }
}
