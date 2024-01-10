<?php

namespace Database\Seeders;

use App\Models\StockItem;
use Illuminate\Database\Seeder;

class StockItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1-6
        for ($i = 1; $i <= 6; $i++) {
            StockItem::create([
                "name" => "Stackable",
                "category_id" => $i,
            ]);
        }
        // 7
        StockItem::create([
            "name" => "polypropylene",
            "category_id" => 7,
        ]);
        StockItem::create([
            "name" => "375mmH",
            "category_id" => 7,
        ]);

        // 8
        StockItem::create([
            "name" => "Polyshell",
            "category_id" => 8,
        ]);
        StockItem::create([
            "name" => "Steel frame",
            "category_id" => 8,
        ]);
        StockItem::create([
            "name" => "400mmH",
            "category_id" => 8,
        ]);

        // 9
        StockItem::create([
            "name" => " polypropylene",
            "category_id" => 9,
        ]);
        StockItem::create([
            "name" => " 450mmH",
            "category_id" => 9,
        ]);

        // 14
        StockItem::create([
            "name" => "450mmH",
            "category_id" => 14,
        ]);

        // 15
        StockItem::create([
            "name" => "690mmH",
            "category_id" => 15,
        ]);
    }
}
