<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrokenItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('broken_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId("collect_req_id")->references("id")->on("collection_requests")->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId("category_id")->constrained("stock_categories");
            $table->foreignId("item_id")->constrained("stock_items");
            $table->integer("item_full_count")->default(0);
            $table->integer("old_count")->default(0);
            $table->integer("count")->default(0);
            $table->integer("confirmed_count")->default(0)->nullable();
            $table->integer("repaired_count")->default(0)->nullable();
            $table->integer("replenished_count")->default(0)->nullable();
            $table->integer("approved_replenished_count")->default(0)->nullable();
            $table->integer("rejected_replenished_count")->default(0)->nullable();
            $table->integer("delivered_count")->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('broken_items');
    }
}
