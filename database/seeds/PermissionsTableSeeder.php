<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions =  [
            'create-employee',
				           'edit-employee',
						   'delete-employee',
						   'apply-leave',
						   'approve-employee',
						   'manage-masterTable',
				           'approve-leave',
				           'approve-probation',
				           'create-company',
				           'edit-company',
				           'approve-company',
				           'create-project',
				           'edit-project',
				           'approve-project',
						   'view-attendance',
						   'approve-travel',
						   'verify-travel-claim',
						   'import-salaryslip',
						   'view-allsalaryslip'
				        ];

		foreach ($permissions as $key => $value) {
        	Permission::create(['name'=>$value]);
        }

    }
}
