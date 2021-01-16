<?php

namespace ZombieAPI\Models\Schema;

use Illuminate\Database\Capsule\Manager as Capsule;

class Report
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Capsule::schema()->create('report', function ($table) {
            $table->integer('id')->unsigned()->unique()->autoIncrement();
            $table->integer('survivor_id')->unsigned();

            $table->foreign('survivor_id')->references('id')->on('survivor')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Capsule::schema()->drop('report');
    }
}
