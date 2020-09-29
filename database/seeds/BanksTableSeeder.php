<?php

use Illuminate\Database\Seeder;
use App\Bank;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("INSERT INTO `banks` (`name`) VALUES
        ('AXIS'),
        ('Bank of India'),
        ('HDFC'),
        ('INDIAN BANK'),
        ('OBC'),
        ('Punjab & Sind Bank'),
        ('PNB'),
        ('State Bank of India'),
        ('State Bank of Patiala'),
        ( 'ALLAHABAD BANK'),
        ( 'ANDHRA BANK'),
        ( 'Bank of Baroda'),
        ( 'Bank of Maharastra'),
        ( 'Canara Bank'),
        ( 'Central Bank of India'),
        ( 'CORPORATION BANK'),
        ( 'Dena'),
        ( 'FEDERAL BANK'),
        ( 'ICICI'),
        ( 'IDBI Bank'),
        ( 'Indian Oversea Bank'),
        ( 'Syndicate'),
        ( 'UCO BANK'),
        ( 'UNION BANK OF INDIA'),
        ( 'UNITED BANK OF INDIA'),
        ( 'Vijaya Bank'),
        ( 'Indusind Bank'),
        ( 'IDBI'),
        ( 'Yes Bank'),
        ( 'Kotak Mahindra bank'),
        ( 'Bank of Maharashtra'),
        ( 'Bank Of America');");
    }
}
