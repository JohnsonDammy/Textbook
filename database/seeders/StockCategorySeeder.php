<?php

namespace Database\Seeders;

use App\Models\StockCategory;
use Illuminate\Database\Seeder;

class StockCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Single Junior Primary Desk', 'Single Primary Desk',
            'Single Secondary Desk', 'Double Junior Primary Desk',
            'Double Primary Desk', 'Double Secondary Desk',
            'Junior Primary Chair', 'Primary Chair', 'Secondary Chair',
            'Single Primary Combination Desk', 'Double Primary Combination Desk',
            'Single Secondary Combination Desk', 'Double Secondary Combination Desk',
            'Primary Laboratory Stool', 'Secondary Laboratory Stool'
        ];

        foreach ($categories as $cat) {
            StockCategory::create([
                "name" => $cat
            ]);
        }
    }
}
