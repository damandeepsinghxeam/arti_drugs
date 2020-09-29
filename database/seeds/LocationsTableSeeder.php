<?php

use Illuminate\Database\Seeder;
use App\Location;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        			['name'=>'Mohali','state_id'=>28],
        			['name'=>'Lucknow','state_id'=>34],
                    ['name'=>'Delhi','state_id'=>10],
        			['name'=>'Chandigarh','state_id'=>6],
        			['name'=>'Ranchi','state_id'=>16],
        			['name'=>'Bangalore','state_id'=>17],
        			['name'=>'Pathankot/Batala','state_id'=>28],
        			['name'=>'Ropar','state_id'=>28],
        			['name'=>'Barnala','state_id'=>28],
        			['name'=>'Amritsar/Patti/Taran','state_id'=>28],
        			['name'=>'Hoshiarpur','state_id'=>28],
        			['name'=>'Jalandhar','state_id'=>28],
        			['name'=>'Patiala','state_id'=>28],
        			['name'=>'Moga','state_id'=>28],
        			['name'=>'Sangrur','state_id'=>28],
        			['name'=>'Ludhiana','state_id'=>28],
        			['name'=>'Bhiwani','state_id'=>13],
        			['name'=>'Hissar','state_id'=>13],
        			['name'=>'Jaipur','state_id'=>29],
        			['name'=>'Assam-Tezpur','state_id'=>4],
        			['name'=>'Bhopal','state_id'=>20],
        			['name'=>'Punchkula','state_id'=>13],
        			['name'=>'Kolkata','state_id'=>36],
        			['name'=>'Zind','state_id'=>13],
        			['name'=>'Ambala','state_id'=>13],
        			['name'=>'Yamunanagar','state_id'=>13],
        			['name'=>'Bhopal(Old)','state_id'=>20],
        			['name'=>'Mumbai','state_id'=>21],
        			['name'=>'Chennai','state_id'=>31]
        			
        		];

        foreach ($data as $key => $value) {
			Location::create($value);
		}
    }
}
