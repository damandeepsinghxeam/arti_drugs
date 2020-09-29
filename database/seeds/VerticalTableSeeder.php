<?php

use Illuminate\Database\Seeder;
use App\Vertical;

class VerticalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
    */
    public function run()
    {
        $verticalTypes = [
         	[
				'name' => 'HRM',
				'description' => 'HRM',
				'isactive' => 1,
			],
			[
				'name' => 'IT / ITeS / digitization',
				'description' => 'IT / ITeS / digitization',
				'isactive' => 1,
			],
			[
				'name' => 'PMU / PIU / PMC',
				'description' => 'PMU / PIU / PMC',
				'isactive' => 1,
			],
			[
				'name' => 'O&M / FMS',
				'description' => 'O&M / FMS',
				'isactive' => 1,
			],
			[
				'name' => 'Survey',
				'description' => 'Survey',
				'isactive' => 1,
			],
			[
				'name' => 'Software',
				'description' => 'Software',
				'isactive' => 1,
			],
			[
				'name' => 'Examination',
				'description' => 'Examination',
				'isactive' => 1,
			],
			[
				'name' => 'Call Centre / BPO / KPO',
				'description' => 'Call Centre / BPO / KPO',
				'isactive' => 1,
			],
			[
				'name' => 'Consultancy',
				'description' => 'Consultancy',
				'isactive' => 1,
			],
			[
				'name' => 'Training',
				'description' => 'Training',
				'isactive' => 1,
			],
			[
				'name' => 'Others',
				'description' => 'Others',
				'isactive' => 1,
			]
		];

		foreach ($verticalTypes as $key => $verticalType) {
        	Vertical::create($verticalType);
        }
    }
}