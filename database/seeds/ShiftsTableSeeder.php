<?php

use Illuminate\Database\Seeder;
use App\Shift;

class ShiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        			['name'=>'Morning Shift','from_time'=>'9:30 AM','to_time'=>'4:00 PM'],
        			['name'=>'Evening Shift','from_time'=>'4:00 PM','to_time'=>'10:00 PM'],
        			['name'=>'Night Shift','from_time'=>'11:00 PM','to_time'=>'8:00 AM']
        			
        		];

        foreach ($data as $key => $value) {
			Shift::create($value);
		}
    }
}
