<?php

use Illuminate\Database\Seeder;
use App\LeadService;

class LeadServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leadServicesData = [
         	[
				'service_name' => 'Recruitment',
				'service_description' => 'Recruitment',
				'isactive' => 1,
				'is_deleted' => 0,
				'created_at' => date('Y-m-d H:i:s')
			],
			[
				'service_name' => 'PayRoll',
				'service_description' => 'PayRoll',
				'isactive' => 1,
				'is_deleted' => 0,
				'created_at' => date('Y-m-d H:i:s')
			],[
				'service_name' => 'Temp Staffing',
				'service_description' => 'Temp Staffing',
				'isactive' => 1,
				'is_deleted' => 0,
				'created_at' => date('Y-m-d H:i:s')
			],
			[
				'service_name' => 'Background Verification',
				'service_description' => 'Background Verification',
				'isactive' => 1,
				'is_deleted' => 0,
				'created_at' => date('Y-m-d H:i:s')
			]
		];

		LeadService::insert($leadServicesData);
    }
}
