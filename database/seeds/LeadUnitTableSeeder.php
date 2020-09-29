<?php

use Illuminate\Database\Seeder;
use App\LeadUnit;

class LeadUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leadUnitData = [
         	[
				'unit_name' => 'Manufacturing',
				'unit_description' => 'Manufacturing',
				'isactive' => 1,
				'is_deleted' => 0,
				'created_at' => date('Y-m-d H:i:s')
			],
			[
				'unit_name' => 'Reforming',
				'unit_description' => 'Reforming',
				'isactive' => 1,
				'is_deleted' => 0,
				'created_at' => date('Y-m-d H:i:s')
			]
		];

		LeadUnit::insert($leadUnitData);
    }
}
