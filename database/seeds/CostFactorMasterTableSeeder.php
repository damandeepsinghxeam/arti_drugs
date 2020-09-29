<?php

use Illuminate\Database\Seeder;
use App\CostFactorMaster;

class CostFactorMasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $costFactorInputs = [
         	[
				'name' => 'Project Mangement / Cordinator cost (HR)',
				'isactive' => 1,
			],
			[
				'name' => 'Travel Costs for Project Mangement',
				'isactive' => 1,
			],
			[
				'name' => 'Office Establishment Cost',
				'isactive' => 1,
			],
			[
				'name' => 'Advertisement for Hiring',
				'isactive' => 1,
			],
			[
				'name' => 'Recruitment Management (HR)',
				'isactive' => 1,
			],
			[
				'name' => 'Id card, Police verification, on boarding & Dcoumentation charges',
				'isactive' => 1,
			],
			[
				'name' => 'IT Facility / Software Support / HRMS / ESS',
				'isactive' => 1,
			],
			[
				'name' => 'Uniform / Dress Code / Shoes / Badges Etc',
				'isactive' => 1,
			],
			[
				'name' => 'Safety Gears / Tool Kits / PPE',
				'isactive' => 1,
			],
			[
				'name' => 'GIS / Accidental Insurance',
				'isactive' => 1,
			],
			[
				'name' => 'Medical Insurance / Workmen Compensation (Lumpsum as per quote)',
				'isactive' => 1,
			],
			[
				'name' => 'Professional Indeminity bond',
				'isactive' => 1,
			],
			[
				'name' => 'Third party liability Insurance',
				'isactive' => 1,
			],
			[
				'name' => 'Procuring Labour License / Other Compalince Registartion',
				'isactive' => 1,
			],
			[
				'name' => 'Leave Encashment / leaves',
				'isactive' => 1,
			],
			[
				'name' => 'Substitution in case of absent / Leave/ Weekly off/ 24*7',
				'isactive' => 1,
			],
			[
				'name' => 'Bonus',
				'isactive' => 1,
			],
			[
				'name' => 'Gratuity',
				'isactive' => 1,
			],
			[
				'name' => 'Labour welfare fund',
				'isactive' => 1,
			],
			[
				'name' => 'Consumables / Stationary',
				'isactive' => 1,
			],
			[
				'name' => 'Mobile allowances',
				'isactive' => 1,
			],
			[
				'name' => 'TA / DA',
				'isactive' => 1,
			],
			[
				'name' => 'Business Promotion',
				'isactive' => 1,
			],
			[
				'name' => 'Provision For Penalty Clauses',
				'isactive' => 1,
			],
			[
				'name' => 'Any Other Cost Specifically Mentioned in the Tender Document',
				'isactive' => 1,
			],
			[
				'name' => 'Security Deposit',
				'isactive' => 1,
			],
			[
				'name' => 'Performance Guarantee',
				'isactive' => 1,
			],
			[
				'name' => 'Payment terms',
				'isactive' => 1,
			],
			[
				'name' => 'TDS',
				'isactive' => 1,
			],
			[
				'name' => 'Others',
				'isactive' => 1,
			]
		];

		foreach ($costFactorInputs as $key => $costFactor) {
        	CostFactorMaster::create($costFactor);
        }
    }
}
