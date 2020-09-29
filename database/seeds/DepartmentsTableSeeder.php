<?php

use Illuminate\Database\Seeder;
use App\Department;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("INSERT INTO `departments` (`name`) VALUES
        ('Admin'),
        ('IT'),
        ('Business Development'),
        ('Accounts'),
        ('Service Delivery'),
        ('HR'),
        ('Management'),
        ('Service Delivery One'),
        ('Lakme'),
        ( 'Service Delivery Two');");
    }
}
