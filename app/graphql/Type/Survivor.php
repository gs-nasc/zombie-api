<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use ZombieAPI\Models\Survivor;

$survivorType = new ObjectType([
    'name' => 'Survivor',
    'description' => 'Data type for survivor',
    'fields' => [
        'id' => Type::int(),
        'name' => Type::string(),
        'birth' => Type::string(),
        'gender' => Type::string(),
        'latitude' => Type::string(),
        'longitude' => Type::string(),
        'infected' => Type::int(),
        'inventory' => [
            'type' => Type::listOf($inventoryType),
            'resolve' => function ($root, $args) {
                $survivor = Survivor::where('id', $root['id'])->with('inventory')->first();
                if($survivor->infected == 0) {
                    return $survivor->inventory->toArray();
                }else {
                    return Array();
                }
            }
        ],
        'reports' => [
            'type' => Type::listOf($reportType),
            'resolve' => function ($root, $args) {
                $survivor = Survivor::where('id', $root['id'])->with('reports')->first();

                return $survivor->reports->toArray();
            }
        ]
    ]
]);
