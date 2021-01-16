<?php

use ZombieAPI\Models\Database;

require "manager.php";

class App
{
    static function start()
    {
        Database::connect();
        include 'app/graphql/index.php';
    }

    static function setup()
    {
        Database::connect();
        Database::setupDatabase();
    }
}
