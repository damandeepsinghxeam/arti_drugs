<?php

use Illuminate\Database\Seeder;
use App\Obligation;

class ObligationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
    */
    public function run()
    {
        $obligationTypes = [
         	[
				'name' => 'Manpower allies (Safety Gear etc.)',
				'description' => 'Manpower allies (Safety Gear etc.)',
				'isactive' => 1,
			],
			[
				'name' => 'HR / Statutory Compliance / Employee benefit',
				'description' => 'HR / Statutory Compliance / Employee benefit',
				'isactive' => 1,
			],
			[
				'name' => 'Operational',
				'description' => 'Operational',
				'isactive' => 1,
			],
			[
				'name' => 'Financial',
				'description' => 'Financial',
				'isactive' => 1,
			]
		];

		foreach ($obligationTypes as $key => $obligationType) {
        	Obligation::create($obligationType);
        }
    }
}