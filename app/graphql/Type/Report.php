<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$reportType = new ObjectType([
    'name' => 'Report',
    'description' => 'Data type for report',
    'fields' => [
        'id' => Type::int(),
        'survivor_id' => Type::int()
    ]
]);