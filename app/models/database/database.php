<?php

namespace ZombieAPI\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use ZombieAPI\Models\Schema\Item;
use ZombieAPI\Models\Schema\Report;
use ZombieAPI\Models\Schema\Survivor;
use ZombieAPI\Models\Schema\SurvivorItemRelation;

class Database
{
    static function connect()
    {
        try {
            $capsule = new Capsule;

            $capsule->addConnection([
                'driver'    => 'mysql',
                'host'      => 'localhost',
                'database'  => 'zombie',
                'username'  => 'root',
                'password'  => '',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ]);

            $capsule->setAsGlobal();
            $capsule->bootEloquent();

        } catch (\Exception $th) {
        }
    }

    static function setupDatabase()
    {

        if (!Capsule::schema()->hasTable('survivor')) {
            $survivorTable = new Survivor;
            $itemTable = new Item;
            $reportsTable = new Report;
            $survivoritemTable = new SurvivorItemRelation;
            try {
                // CRIANDO TABELA DE SOBREVIVENTES
                $survivorTable->up();
                // CRIANDO E POPULANDO TABELA DE ITEMS
                $itemTable->up();
                // CRIANDO A RELAÇÃO ENTRE OS DOIS
                $survivoritemTable->up();
                // CRIANDO TABELA DE REPORTS
                $reportsTable->up();
            } catch (\Exception $ex) {
                $survivorTable->down();
                $itemTable->down();
                $survivoritemTable->down();
                $reportsTable->down();
                echo $ex->getMessage();
            }
        }
    }
}
