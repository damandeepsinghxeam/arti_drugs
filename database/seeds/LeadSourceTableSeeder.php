<?php

use Illuminate\Database\Seeder;
use App\LeadSource;

class LeadSourceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leadSourceData = [
         	[
				'source_name' => 'Newspaper',
				'source_description' => 'Newspaper',
				'isactive' => 1,
				'is_deleted' => 0,
				'created_at' => date('Y-m-d H:i:s')
			],
			[
				'source_name' => 'Website/Internet',
				'source_description' => 'Website/Internet',
				'isactive' => 1,
				'is_deleted' => 0,
				'created_at' => date('Y-m-d H:i:s')
			],
			[
				'source_name' => 'Friend',
				'source_description' => 'Friend',
				'isactive' => 1,
				'is_deleted' => 0,
				'created_at' => date('Y-m-d H:i:s')
			],
			[
				'source_name' => 'Others',
				'source_description' => 'Others',
				'isactive' => 1,
				'is_deleted' => 0,
				'created_at' => date('Y-m-d H:i:s')
			]
		];

		LeadSource::insert($leadSourceData);
    }
}
