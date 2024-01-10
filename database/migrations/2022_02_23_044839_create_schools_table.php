<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('emis');
            $table->foreignId('district_id')->nullable()->references("id")->on('school_districts')->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId('cmc_id')->nullable()->references("id")->on('c_m_c_s')->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId('circuit_id')->nullable()->references("id")->on('circuits')->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId('subplace_id')->nullable()->references("id")->on('subplaces')->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId('snq_id')->nullable()->references("id")->on('school_snqs')->onDelete("cascade")->onUpdate("cascade");
            $table->foreignId('level_id')->nullable()->references("id")->on('school_levels')->onDelete("cascade")->onUpdate("cascade");
            $table->string('school_principal')->nullable();
            $table->string('tel', 15)->nullable();
            $table->bigInteger('street_code')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('schools');
    }
}
