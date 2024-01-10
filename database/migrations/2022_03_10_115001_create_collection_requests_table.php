<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_requests', function (Blueprint $table) {
            $table->id();
            $table->string("ref_number", 30)->unique();
            $table->foreignId("user_id")->constrained("users");
            $table->string("school_name");
            $table->bigInteger("emis");
            $table->integer("total_broken_items")->default(0);
            $table->integer("total_furniture");
            $table->foreignId("status_id")->constrained("request_statuses")->default(1);
            $table->foreignId("replenishment_status")->nullable()->constrained("replenishment_statuses");
            $table->foreignId('district_id')->constrained('school_districts');
            $table->string("district_name");
            $table->timestamps();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('collected_at')->nullable();
            $table->timestamp('repaired_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collection_requests');
    }
}
