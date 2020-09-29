<?php

use Illuminate\Database\Seeder;
use App\LeadIndustry;

class LeadIndustryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leadIndustryData = [
         	[
				'industry_name' => 'Health & Care',
				'industry_description' => 'Health & Care',
				'isactive' => 1,
				'is_deleted' => 0,
				'created_at' => date('Y-m-d H:i:s')
			],
			[
				'industry_name' => 'Oil & Gas',
				'industry_description' => 'Oil & Gas',
				'isactive' => 1,
				'is_deleted' => 0,
				'created_at' => date('Y-m-d H:i:s')
			]
		];

		LeadIndustry::insert($leadIndustryData);
    }
}
