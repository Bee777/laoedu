<?php

use Illuminate\Database\Seeder;
use App\EducationDegree;
class EducationDegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EducationDegree::create(['name' => 'Associate’s Degrees']);
        EducationDegree::create(['name' => 'Bachelor’s Degrees']);
        EducationDegree::create(['name' => 'Master’s Degrees']);
        EducationDegree::create(['name' => 'Doctoral Degrees']);
    }
}
