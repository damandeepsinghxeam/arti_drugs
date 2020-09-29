<?php

use Illuminate\Database\Seeder;

class SalaryCyclePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'index-salary-cycle',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'create-salary-cycle',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'update-salary-cycle',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'delete-salary-cycle',
            'guard_name' =>  'web'
        ]);
    }
}
