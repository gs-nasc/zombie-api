<?php

namespace ZombieAPI\Models\Schema;

use Illuminate\Database\Capsule\Manager as Capsule;

class Item
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Capsule::schema()->create('item', function ($table) {
            $table->integer('id')->unsigned()->unique()->autoIncrement();
            $table->string('name');
            $table->string('points');
        });

        $this->items();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Capsule::schema()->drop('item');
    }

    public function items()
    {
        Capsule::table('item')->insert([
            ['name' => 'Água', 'points' => 4],
            ['name' => 'Comida', 'points' => 3],
            ['name' => 'Medicamento', 'points' => 2],
            ['name' => 'Munição', 'points' => 1]
        ]);
    }
}
