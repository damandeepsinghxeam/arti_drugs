<?php

use Illuminate\Database\Seeder;
use App\Skill;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("INSERT INTO `skills` (`name`) VALUES
        ('C'),
        ('Php'),
        ('Java'),
        ('Python'),
        ('Ruby'),
        ('Node js'),
        ('C++'),
        ('C#'),
        ('F#'),
        ( 'Management'),
        ( 'Clerical'),
        ( 'Tally'),
        ( 'Organizational skills'),
        ( 'Office Management'),
        ( 'Decision-making'),
        ( 'Manual Testing'),
        ( 'Selenium'),
        ( 'Node.js'),
        ( 'Jmeter'),
        ( 'HTML'),
        ( 'CSS'),
        ( 'Jquery'),
        ( 'Java Script'),
        ( 'Project Management'),
        ( 'Digital Marketing'),
        ( 'Graphic Designer'),
        ( 'Web designer'),
        ( 'System Management'),
        ( 'Network Management'),
        ( 'SEO'),
        ( 'S.M.O'),
        ( 'Website Management'),
        ( 'Design Management'),
        ( 'Computer Hardware Maintenance'),
        ( 'LAN'),
        ( 'Troubleshooting'),
        ( 'Business Development'),
        ( 'Client Acquisition'),
        ( 'Recruitment'),
        ( 'Compliance'),
        ( 'HR - Generalist'),
        ( 'Emp ID Genrartion'),
        ( 'To Genrarte PF/ESI'),
        ( 'Account Management'),
        ( 'Brand Management'),
        ( 'Strategic Marketing'),
        ( 'Contract Negotiation'),
        ( 'Integrated Marketing'),
        ( 'Staff Management'),
        ( 'Sales Planning & Analysis'),
        ( 'Lead Generation'),
        ( 'Google Analytics'),
        ( 'Data Analysis'),
        ( 'Outbound Marketing'),
        ( 'Social Media Advertising'),
        ( 'Finance'),
        ( 'Accounts'),
        ( 'Trainer'),
        ( 'Counsellor'),
        ( 'Hair Trainer'),
        ( 'Makeup Artist');");
    }
}
