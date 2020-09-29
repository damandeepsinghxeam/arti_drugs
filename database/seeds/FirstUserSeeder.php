<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Employee;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class FirstUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_data = [
        				'employee_code' => 'XEAM001',
        				'email' => 'admin@xeam.com',
        				'password' => bcrypt('123456')
        			];

        $user = User::create($user_data);

        $employee_data = [
        					'user_id' => 1,
        					'creator_id' => 1,
        					'employee_id' => 'XEAM-001',
        					'salutation' => 'Mr.',
        					'fullname' => 'Super Admin',
        					'first_name' => 'Super',
        					'last_name' => 'Admin',
        					'mobile_number' => '9999999999',
        					'country_id' => 1,
        					'alt_country_id' => 1,
        					'experience_year_month' => '8-7',
        					'experience_status' => '1',
        					'marital_status' => 'Unmarried',
        					'gender' => 'Male',
        					'approval_status' => '1',
                            'spouse_designation' => 0,
                            'joining_date' => date("Y-m-d")
        				];

        $employee = Employee::create($employee_data);
        $user->assignRole(['Main Administrator']);

        $permissions = Permission::pluck('name')->toArray();
        $user->syncPermissions($permissions);

        $employee_profile_data = [
                                    'probation_period_id' => 1,
                                    'probation_end_date' => date("Y-m-d"),
                                    'probation_approval_status' => '1',
                                    'probation_hod_approval' => '1',
                                    'probation_hr_approval' => '1',
                                    'state_id' => 1,
                                    'shift_id' => 1,
                                    'department_id' => 1
                                 ];

        $user->employeeProfile()->create($employee_profile_data);
        $user->approval()->create(['approver_id'=>1]);

        $data = [
                    ['user_id'=>1, 'designation_id'=>1]
                ];

        foreach ($data as $key => $value) {
            DB::table('designation_user')->insert($value);
        }
        DB::statement("INSERT INTO `employee_accounts` (`user_id`, `adhaar`, `pan_number`, `uan_number`, `account_holder_name`, `bank_account_number`, `esi_number`, `dispensary`, `ifsc_code`, `pf_number_department`, `bank_id`, `contract_signed`, `contract_signed_date`, `employment_verification`, `address_verification`, `police_verification`, `remarks`, `isactive`, `created_at`, `updated_at`) VALUES ( '1', '1321458456', 'BIOP700564', 'UANAOS', 'Super Admin', '0000000326017293569', 'ESI0001', 'D56544454', 'IFSC000225', NULL, '1', '0', '2019-05-08', '1', '1', '1', NULL, '1', NULL, NULL);");
    }
}
