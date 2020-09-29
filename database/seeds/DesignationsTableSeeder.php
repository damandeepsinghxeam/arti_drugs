<?php

use Illuminate\Database\Seeder;

class DesignationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("INSERT INTO `designations` (`name`, `short_name`, `isactive`, `hierarchy`, `band_id`, `sort_order`, `created_at`, `updated_at`) VALUES
        ('Managing Director', 'MD', 1, 1, 1, 0, NULL, NULL),
        ('Vice President', 'VP', 1, 2, 3, 0, NULL, NULL),
        ('AVP', 'Assistant Vice President', 1, 3, 3, 0, NULL, NULL),
        ('Sr. GM', 'Sr. General Manager', 1, 4, 3, 0, NULL, NULL),
        ('GM', 'General Manager', 1, 5, 3, 0, NULL, NULL),
        ('DGM', 'Sr. Deputy General Manager', 1, 6, 4, 0, NULL, NULL),
        ('AGM', 'Assistant General Manager', 1, 7, 4, 0, NULL, NULL),
        ('Sr.Manager', 'Sr. Manager', 1, 8, 5, 0, NULL, NULL),
        ('Manager', 'Manager', 1, 9, 5, 0, NULL, NULL),
        ( 'AM', 'Assistant Manager', 1, 10, 5, 0, NULL, NULL),
        ( 'Sr.Executive', 'Sr.Executive', 1, 11, 6, 0, NULL, NULL),
        ( 'Executive', 'Executive', 1, 12, 6, 0, NULL, NULL),
        ( 'Trainee', 'Trainee', 1, 13, 6, 0, NULL, NULL)");
    }
}
