<?php

use Illuminate\Database\Seeder;
use App\Qualification;

class QualificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement("INSERT INTO `qualifications` (`name`) VALUES
		('HIGH SCHOOL'),
		('BCA'),
		('B.COM'),
		('M.COM'),
		('B.SC(IT)'),
		('M.SC(IT)'),
		('B.SC(COMPUTER SCIENCE)'),
		('M.SC(COMPUTER SCIENCE)'),
		('BA'),
		( 'BBA'),
		( 'MA'),
		( 'PHD'),
		( 'MBA'),
		( 'B.Tech'),
		( 'MCA'),
		( 'B.SC'),
		( 'MCP'),
		( 'MBA - HR & Finance'),
		( 'MBA - HR'),
		( 'MBA - HR & Marketing'),
		( 'PGDMA'),
		( 'Diploma'),
		( 'CMA-INTER'),
		( 'MSW'),
		( 'PGDCA'),
		( 'Master in cosmolodgy'),
		( 'Graduation'),
		( 'Post Graduation');");

    }
}
