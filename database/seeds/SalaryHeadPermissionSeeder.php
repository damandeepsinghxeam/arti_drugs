<?php

use Illuminate\Database\Seeder;

class SalaryHeadPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'index-salary-head',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'create-salary-head',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'update-salary-head',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'delete-salary-head',
            'guard_name' =>  'web'
        ]);
    }
}
