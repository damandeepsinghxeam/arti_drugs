<?php

use Illuminate\Database\Seeder;

class SalarySheetPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'index-salary-sheet',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'create-salary-sheet',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'update-salary-sheet',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'delete-salary-sheet',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'for-approve-salary-sheet',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'hold-salary-sheet',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'approve-salary-sheet',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'pay-salary-sheet',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'add-arrear',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'add-deduction',
            'guard_name' =>  'web'
        ]);
    }
}
