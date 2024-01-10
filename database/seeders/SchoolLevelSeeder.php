<?php

namespace Database\Seeders;

use App\Models\SchoolLevel;
use Illuminate\Database\Seeder;

class SchoolLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SchoolLevel::create([
            "name" => "P"
        ]);
        SchoolLevel::create([
            "name" => "S"
        ]);
        SchoolLevel::create([
            "name" => "C"
        ]);
    }
}
