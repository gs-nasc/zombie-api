<?php

use GraphQL\Type\Definition\ObjectType;

require 'Mutation/Survivor.php';
require 'Mutation/Relatory.php';

$mutations = array();

$mutations += $survivorMutation;
$mutations += $relatoryMutation;

$rootMutation = new ObjectType([
    'name' => 'Mutation',
    'fields' => $mutations
]);