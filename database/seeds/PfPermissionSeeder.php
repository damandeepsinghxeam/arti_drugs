<?php

use Illuminate\Database\Seeder;

class PfPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'index-pf',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'create-pf',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'update-pf',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'delete-pf',
            'guard_name' =>  'web'
        ]);
    }
}
