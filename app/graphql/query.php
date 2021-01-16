<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use ZombieAPI\Models\Inventory;
use ZombieAPI\Models\Item;
use ZombieAPI\Models\Survivor;

require 'Type/Item.php';
require 'Type/Inventory.php';
require 'Type/Report.php';
require 'Type/Survivor.php';
require 'Type/Relatory.php';

$rootQuery = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'survivor' => [
            'type' => $survivorType,
            'args' => [
                'id' => Type::nonNull(Type::int())
            ],
            'resolve' => function ($root, $args) {
                $survivor = Survivor::find($args["id"])->toArray();
                return $survivor;
            }
        ],
        'survivors' => [
            'type' => Type::listOf($survivorType),
            'resolve' => function ($root, $args) {
                $survivors = Survivor::get()->toArray();
                return $survivors;
            }
        ],
    ]
]);
