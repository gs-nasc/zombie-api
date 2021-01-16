<?php

namespace ZombieAPI\Models\Schema;

use Illuminate\Database\Capsule\Manager as Capsule;

class Survivor
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Capsule::schema()->create('survivor', function ($table) {
            $table->integer('id')->unsigned()->unique()->autoIncrement();
            $table->string('name');
            $table->date('birth');
            $table->string('gender');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('infected');
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
        Capsule::schema()->drop('survivor');
    }
}
