<?php

namespace Database\Seeders;

use App\Models\RequestStatus;
use Illuminate\Database\Seeder;

class RequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = ["Pending Collection", "Collection Accepted", "Pending Repairs", "Repair Completed", "Pending Delivery", "Delivery Confirmed"];
        foreach ($status as $item) {
            RequestStatus::create([
                "name" => $item
            ]);
        }
    }
}
