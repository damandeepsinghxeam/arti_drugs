<?php

use Illuminate\Database\Seeder;
use App\Log;

class LogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        			'Company-Updated',
        			'Project-Updated',
                    'User-Updated'
        		];

        foreach($data as $key => $value) {
			Log::create(['name'=>$value]);
		}		
    }
}
