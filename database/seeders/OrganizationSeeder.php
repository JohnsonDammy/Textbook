<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$organizations = ['Dinnovation', 'School', 'Department of Education'];
        Organization::create([
            "name" => 'Furniture Depot',
            "permissions" => [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,25,26,27,28,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48]
        ]);
        Organization::create([
            "name" => 'School',
            "permissions" => [21,22,25,29,31,32,33]
        ]);
        Organization::create([
            "name" => 'Department of Education',
            "permissions" => [33]
        ]);
    }
}
