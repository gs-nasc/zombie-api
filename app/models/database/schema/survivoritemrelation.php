<?php

namespace ZombieAPI\Models\Schema;

use Illuminate\Database\Capsule\Manager as Capsule;

class SurvivorItemRelation
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Capsule::schema()->create('survivor_item', function ($table) {
            $table->integer('id')->unsigned()->unique()->autoIncrement();
            $table->integer('survivor_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->integer('qty');

            $table->foreign('survivor_id')->references('id')->on('survivor')->unsigned();
            $table->foreign('item_id')->references('id')->on('item')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Capsule::schema()->drop('survivor_item');
        
    }
}
