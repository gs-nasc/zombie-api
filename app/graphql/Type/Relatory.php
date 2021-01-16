<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$relatoryType = new ObjectType([
    'name' => 'Relatory',
    'description' => 'Data type for relatory',
    'fields' => [
        'value' => Type::string()
    ]
]);