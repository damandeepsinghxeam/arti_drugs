<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("INSERT INTO `states` ( `country_id`, `name`, `created_at`, `updated_at`) VALUES
                ( 1, 'Andaman and Nicobar Islands', NULL, NULL),
                ( 1, 'Andhra Pradesh', NULL, NULL),
                ( 1, 'Arunachal Pradesh', NULL, NULL),
                ( 1, 'Assam', NULL, NULL),
                ( 1, 'Bihar', NULL, NULL),
                ( 1, 'Chandigarh', NULL, NULL),
                ( 1, 'Chhattisgarh', NULL, NULL),
                ( 1, 'Dadra and Nagar Haveli', NULL, NULL),
                ( 1, 'Daman and Diu', NULL, NULL),
                ( 1, 'Delhi', NULL, NULL),
                (1, 'Goa', NULL, NULL),
                ( 1, 'Gujarat', NULL, NULL),
                ( 1, 'Haryana', NULL, NULL),
                ( 1, 'Himachal Pradesh', NULL, NULL),
                ( 1, 'Jammu and Kashmir', NULL, NULL),
                ( 1, 'Jharkhand', NULL, NULL),
                ( 1, 'Karnataka', NULL, NULL),
                ( 1, 'Kerala', NULL, NULL),
                ( 1, 'Lakshadweep', NULL, NULL),
                ( 1, 'Madhya Pradesh', NULL, NULL),
                ( 1, 'Maharashtra', NULL, NULL),
                ( 1, 'Manipur', NULL, NULL),
                ( 1, 'Meghalaya', NULL, NULL),
                ( 1, 'Mizoram', NULL, NULL),
                ( 1, 'Nagaland', NULL, NULL),
                ( 1, 'Orissa', NULL, NULL),
                ( 1, 'Punducherry', NULL, NULL),
                ( 1, 'Punjab', NULL, NULL),
                ( 1, 'Rajasthan', NULL, NULL),
                ( 1, 'Sikkim', NULL, NULL),
                ( 1, 'Tamil Nadu', NULL, NULL),
                ( 1, 'Telangana', NULL, NULL),
                ( 1, 'Tripura', NULL, NULL),
                ( 1, 'Uttar Pradesh', NULL, NULL),
                ( 1, 'Uttarakhand', NULL, NULL),
                ( 1, 'West Bengal', NULL, NULL)");

    }
}
