<?php



use Illuminate\Database\Seeder;

use App\LeaveType;



class LeaveTypesTableSeeder extends Seeder

{

    /**

     * Run the database seeds.

     *

     * @return void

     */

    public function run()

    {

        $data = [

        			['name'=>'Casual Leave'],

        			['name'=>'Sick Leave'],

        			['name'=>'Unpaid Leave'],

        			['name'=>'Maternity Leave'],

                    ['name'=>'Compensatory Leave'],
                    ['name'=>'Late Coming']

        			

        		];



        foreach ($data as $key => $value) {

			LeaveType::create($value);

		}

    }

}

