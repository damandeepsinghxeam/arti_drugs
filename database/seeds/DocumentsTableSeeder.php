<?php

use Illuminate\Database\Seeder;
use App\Document;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
        			['document_category_id'=>1,'name'=>'Bank Document'],
        			['document_category_id'=>1,'name'=>'Driving License'],
        			['document_category_id'=>1,'name'=>'Resume'],
        			['document_category_id'=>1,'name'=>'Diploma'],
        			['document_category_id'=>2,'name'=>'Leave Policy 1'],
        			['document_category_id'=>3,'name'=>'Project Agreement'],
        			['document_category_id'=>3,'name'=>'Agreement File'],
        			['document_category_id'=>3,'name'=>'LOI File'],
        			['document_category_id'=>3,'name'=>'Offer Letter File'],
        			['document_category_id'=>3,'name'=>'Employee Contract File 1'],
        			['document_category_id'=>3,'name'=>'Employee Contract File 2'],
        			['document_category_id'=>3,'name'=>'Employee Contract File 3']
        			
        		];

        foreach ($data as $key => $value) {
			Document::create($value);
		}
    }
}
