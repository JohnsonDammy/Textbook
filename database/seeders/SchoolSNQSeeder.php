<?php

namespace Database\Seeders;

use App\Models\SchoolSnq;
use Illuminate\Database\Seeder;

class SchoolSNQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $level = [1, 2, 3, 4, 5];
        foreach ($level as $key => $value) {
            SchoolSnq::create([
                "name" => $value
            ]);
        }
    }
}
