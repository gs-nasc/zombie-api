<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use ZombieAPI\Models\Inventory;

$inventoryType = new ObjectType([
    'name' => 'Inventory',
    'description' => 'Data type for inventory',
    'fields' => [
        'id' => Type::int(),
        'survivor_id' => Type::int(),
        'item_id' => Type::int(),
        'qty' => Type::int(),
        'items' => [
            'type' => $itemType,
            'resolve' => function($root, $args) {
                $inventoryId = $root['id'];
                $inventory = Inventory::where('id', $inventoryId)->with(['item'])->first();
                return $inventory->item->toArray();
            }
        ]
    ]
]);