<?php

namespace Database\Seeders;

use App\Models\ReplenishmentStatus;
use Illuminate\Database\Seeder;


class ReplenishmentstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */




    public function run()
    {
        $status = ["Pending Replenishment Approval", "Finalised Replenishment Decision"];
        foreach ($status as $item) {
            ReplenishmentStatus::create([
                "name" => $item
            ]);
        }
    }
}
