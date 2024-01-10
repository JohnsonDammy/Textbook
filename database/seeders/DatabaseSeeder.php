<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            PermissionTableSeeder::class,
            OrganizationSeeder::class,
            StockCategorySeeder::class,
            StockItemSeeder::class,
            RequestStatusSeeder::class,
            ReplenishmentstatusSeeder::class,
            SchoolSNQSeeder::class,
            SchoolLevelSeeder::class,
            SuperAdminUserSeeder::class
        ]);
    }
}
