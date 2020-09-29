<?php

use Illuminate\Database\Seeder;
use App\CostFactorTypes;

class CostFactorTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $costFactorTypeInputs = [
         	[
				'name' => 'Capital',
				'isactive' => 1,
			],
			[
				'name' => 'Operational',
				'isactive' => 1,
			]
		];

		foreach ($costFactorTypeInputs as $key => $costFactorType) {
        	CostFactorTypes::create($costFactorType);
        }
    }
}