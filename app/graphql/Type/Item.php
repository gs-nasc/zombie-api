<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$itemType = new ObjectType([
    'name' => 'Item',
    'description' => 'Data type for item',
    'fields' => [
        'id' => Type::int(),
        'name' => Type::string(),
        'points' => Type::int()
    ]
]);