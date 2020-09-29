<?php

use Illuminate\Database\Seeder;
use App\FeeType;

class FeeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $feeTypes = [
         	[
				'name' => 'DD',
				'is_emd' => 1,
				'is_processing_fee' => 1,
				'is_tender_fee' => 1,
				'isactive' => 1,
			],
			[
				'name' => 'BC',
				'is_emd' => 1,
				'is_processing_fee' => 1,
				'is_tender_fee' => 1,
				'isactive' => 1,
			],
			[
				'name' => 'TDR',
				'is_emd' => 1,
				'is_processing_fee' => 0,
				'is_tender_fee' => 0,
				'isactive' => 1,
			],
			[
				'name' => 'FDR',
				'is_emd' => 1,
				'is_processing_fee' => 0,
				'is_tender_fee' => 0,
				'isactive' => 1,
			],
			[
				'name' => 'Neft',
				'is_emd' => 1,
				'is_processing_fee' => 1,
				'is_tender_fee' => 1,
				'isactive' => 1,
			],
			[
				'name' => 'Online',
				'is_emd' => 1,
				'is_processing_fee' => 1,
				'is_tender_fee' => 1,
				'isactive' => 1,
			],
			[
				'name' => 'BG',
				'is_emd' => 1,
				'is_processing_fee' => 1,
				'is_tender_fee' => 1,
				'isactive' => 1,
			],
			[
				'name' => 'Exempted',
				'is_emd' => 1,
				'is_processing_fee' => 1,
				'is_tender_fee' => 1,
				'isactive' => 1,
			],
			[
				'name' => 'Not applicable',
				'is_emd' => 1,
				'is_processing_fee' => 1,
				'is_tender_fee' => 1,
				'isactive' => 1,
			]
		];

		foreach ($feeTypes as $key => $feeType) {
        	FeeType::create($feeType);
        }
    }
}