<?php

use Illuminate\Database\Seeder;

class EsiPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
           'name' => 'index-esi',
           'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'create-esi',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'update-esi',
            'guard_name' =>  'web'
        ]);

        DB::table('permissions')->insert([
            'name' => 'delete-esi',
            'guard_name' =>  'web'
        ]);
    }
}
