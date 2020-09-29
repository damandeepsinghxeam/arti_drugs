<?php

use Illuminate\Database\Seeder;
use App\Language;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("INSERT INTO `languages` ( `name`) VALUES
        ( 'Urdu'),
        ( 'English'),
        ( 'Punjabi'),
        ( 'Marathi'),
        ( 'Bengali'),
        ( 'Assammesse'),
        ( 'Hindi'),
        ( 'Oriya'),
        ( 'Gujarati'),
        ( 'Telugu'),
        ( 'Tamil'),
        ( 'Kannada'),
        ( 'Malayalam'),
        ( 'Maithili'),
        ( 'Santali'),
        ( 'Kashmiri'),
        ( 'Sindhi'),
        ( 'Konkani'),
        ( 'Dogri'),
        ( 'Manipuri'),
        ( 'Khasi'),
        ( 'Mundari'),
        ( 'Bodo'),
        ( 'Kurukh');");
    }
}
