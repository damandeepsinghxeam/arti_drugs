<?php

use Illuminate\Database\Seeder;

class PtRatePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'index-pt-rate',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'create-pt-rate',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'update-pt-rate',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'delete-pt-rate',
            'guard_name' =>  'web'
        ]);
    }
}
