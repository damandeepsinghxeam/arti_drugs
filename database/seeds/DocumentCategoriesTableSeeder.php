<?php

use Illuminate\Database\Seeder;
use App\DocumentCategory;

class DocumentCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        			['name'=>'Employee'],
        			['name'=>'Leave'],
        			['name'=>'Project']
        			
        		];

        foreach ($data as $key => $value) {
			DocumentCategory::create($value);
		}
    }
}
