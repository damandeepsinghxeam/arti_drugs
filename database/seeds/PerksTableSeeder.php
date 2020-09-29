<?php

use Illuminate\Database\Seeder;
use App\Perk;

class PerksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        			['name'=>'Travel Allowance'],
        			['name'=>'Medical Facility'],
        			['name'=>'Food Voucher']
        		];

        foreach ($data as $key => $value) {
			Perk::create($value);
		}
    }
}
