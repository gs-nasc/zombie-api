<?php

use GraphQL\GraphQL;
use GraphQL\Type\Schema;

require 'query.php';
require 'mutations.php';

$schema = new Schema([
    'query' => $rootQuery,
    'mutation' => $rootMutation
]);

try {
    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);
    $query = $input['query'];
    $result = GraphQL::executeQuery($schema, $query);

    $output = $result->toArray();
} catch (\Exception $ex) {
    $output = [
        'error' => [
            'message' => $ex->getMessage()
        ]
    ];
}

header('Content-Type: application/json');

echo json_encode($output, JSON_UNESCAPED_UNICODE);
