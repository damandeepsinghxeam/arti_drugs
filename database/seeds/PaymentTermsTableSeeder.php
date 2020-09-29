<?php

use Illuminate\Database\Seeder;
use App\PaymentTerm;

class PaymentTermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentTerms = [
         	[
				'payment_type_id' => 1,
				'name'            => 'Within 15 days',
				'description'     => 'Within 15 days',
				'isactive'        => 1,
			],
			[
				'payment_type_id' => 1,
				'name'            => 'Monthly',
				'description'     => 'Monthly',
				'isactive'        => 1,
			],
			[
				'payment_type_id' => 1,
				'name'            => 'Bi-Monthly',
				'description'     => 'Bi-Monthly',
				'isactive'        => 1,
			],
			[
				'payment_type_id' => 1,
				'name'            => 'Quarterly',
				'description'     => 'Quarterly',
				'isactive'        => 1,
			],
			[
				'payment_type_id' => 1,
				'name'            => 'Other',
				'description'     => 'Other',
				'isactive'        => 1,
			],
			[
				'payment_type_id' => 2,
				'name'            => 'Monthly',
				'description'     => 'Monthly',
				'isactive'        => 1,
			],
			[
				'payment_type_id' => 2,
				'name'            => 'Bi-Monthly',
				'description'     => 'Bi-Monthly',
				'isactive'        => 1,
			],
			[
				'payment_type_id' => 2,
				'name'            => 'Quarterly',
				'description'     => 'Quarterly',
				'isactive'        => 1,
			],
			[
				'payment_type_id' => 2,
				'name'            => 'Against security BG.',
				'description'     => 'Against security BG.',
				'isactive'        => 1,
			],
			[
				'payment_type_id' => 2,
				'name'            => 'Escrow Account',
				'description'     => 'Escrow Account',
				'isactive'        => 1,
			],
			[
				'payment_type_id' => 2,
				'name'            => 'Direct revenue collection (for O&amp;M / turnkey / FMS projects)',
				'description'     => 'Direct revenue collection (for O&amp;M / turnkey / FMS projects)',
				'isactive'        => 1,
			]
		];

		foreach ($paymentTerms as $key => $paymentTerm) {
        	PaymentTerm::create($paymentTerm);
        }
    }
}