<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("INSERT INTO `countries` (`name`, `phone_code`, `iso2`, `iso3`, `created_at`, `updated_at`) VALUES
			('India', '91', 'IN', 'IND', NULL, NULL)");
    }
}
