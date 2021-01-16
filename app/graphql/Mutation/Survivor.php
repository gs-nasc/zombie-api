<?php

use GraphQL\Type\Definition\Type;
use ZombieAPI\Models\Inventory;
use ZombieAPI\Models\Item;
use ZombieAPI\Models\Report;
use ZombieAPI\Models\Survivor;

$survivorMutation = [
    'addSurvivor' => [
        'type' => $survivorType,
        'args' => [
            'name' => Type::nonNull(Type::string()),
            'birth' => Type::nonNull(Type::string()),
            'gender' => Type::nonNull(Type::string()),
            'latitude' => Type::nonNull(Type::string()),
            'longitude' => Type::nonNull(Type::string()),
            'infected' => Type::nonNull(Type::int()),
            'water' => Type::int(),
            'food' => Type::int(),
            'drug' => Type::int(),
            'munition' => Type::int()
        ],
        'resolve' => function ($root, $args) {
            $survivor = new Survivor([
                'name' => $args['name'],
                'birth' => $args['birth'],
                'gender' => $args['gender'],
                'latitude' => $args['latitude'],
                'longitude' => $args['longitude'],
                'infected' => $args['infected']
            ]);
            $survivor->save();

            $water_qty = ($args['water'] != NULL) ? $args['water'] : 0;
            $food_qty = ($args['food'] != NULL) ? $args['food'] : 0;
            $drug_qty = ($args['drug'] != NULL) ? $args['drug'] : 0;
            $munition_qty = ($args['munition'] != NULL) ? $args['munition'] : 0;

            $water = new Inventory([
                'survivor_id' => $survivor->id,
                'item_id' => 1,
                'qty' => intval($water_qty)
            ]);
            $food = new Inventory([
                'survivor_id' => $survivor->id,
                'item_id' => 2,
                'qty' => intval($food_qty)
            ]);
            $drug = new Inventory([
                'survivor_id' => $survivor->id,
                'item_id' => 3,
                'qty' => intval($drug_qty)
            ]);
            $munition = new Inventory([
                'survivor_id' => $survivor->id,
                'item_id' => 4,
                'qty' => intval($munition_qty)
            ]);

            $water->save();
            $food->save();
            $drug->save();
            $munition->save();

            $survivor = Survivor::where('id', $survivor->id)->with('inventory')->first();
            return $survivor->toArray();
        }
    ],
    'updateSurvivorLocation' => [
        'type' => $survivorType,
        'args' => [
            'id' => Type::nonNull(Type::int()),
            'latitude' => Type::string(),
            'longitude' => Type::string()
        ],
        'resolve' => function ($root, $args) {
            $survivor = Survivor::find($args['id']);
            $survivor->latitude = isset($args['latitude']) ? $args['latitude'] : $survivor->latitude;
            $survivor->longitude = isset($args['longitude']) ? $args['longitude'] : $survivor->longitude;

            $survivor->save();
            return $survivor->toArray();
        }
    ],
    'reportSurvivor' => [
        'type' => $reportType,
        'args' => [
            'survivor_id' => Type::nonNull(Type::int())
        ],
        'resolve' => function ($root, $args) {
            $report = new Report(
                [
                    'survivor_id' => $args['survivor_id']
                ]
            );
            $report->save();

            $reports = Report::where('survivor_id', $args['survivor_id'])->get()->toArray();

            if (count($reports) == 3) {
                $survivor = Survivor::find($args['survivor_id']);
                $survivor->infected = 1;
                $survivor->save();
            }

            return $report->toArray();
        }
    ],
    'tradeItem' => [
        'type' => Type::listOf($inventoryType),
        'args' => [
            'trader_id' => Type::nonNull(Type::int()),
            'customer_id' => Type::nonNull(Type::int()),
            'trader_item_id' => Type::nonNull(Type::int()),
            'trader_item_qty' => Type::nonNull(Type::int()),
            'customer_item_id' => Type::nonNull(Type::int()),
            'customer_item_qty' => Type::nonNull(Type::int())
        ],
        'resolve' => function ($root, $args) {
            $trader_id = $args['trader_id'];
            $customer_id = $args['customer_id'];

            $trader = Survivor::where('id', $trader_id)->with('inventory')->first();
            $customer = Survivor::where('id', $customer_id)->with('inventory')->first();

            if ($trader->infected == 1 || $customer->infected == 1) {
                throw new Exception("Trader or customer is infected, trade cancelled");
            } else {
                $trader_inventory = $trader->inventory;
                $customer_inventory = $customer->inventory;

                $trader_item_key = NULL;
                $trader_new_item_key = NULL;
                $trader_item_points_value = NULL;

                $customer_item_key = NULL;
                $customer_new_item_key = NULL;
                $customer_item_points_value = NULL;

                foreach ($trader_inventory as $key => $value) {
                    if ($value->item_id == $args['trader_item_id']) {
                        if ($value->qty < $args['trader_item_qty']) {
                            throw new Exception("The trader amount of trade is greater than he has");
                        } else {
                            $i = Item::where('id', $value->item_id)->first();
                            $trader_item_key = $key;
                            $trader_item_points_value = $args['trader_item_qty'] * $i->points;
                        }
                    } else if ($value->item_id == $args['customer_item_id']) {
                        $trader_new_item_key = $key;
                    }
                }

                foreach ($customer_inventory as $key => $value) {
                    if ($value->item_id == $args['customer_item_id']) {
                        if ($value->qty < $args['customer_item_qty']) {
                            throw new Exception("The customer amount of trade is greater than he has");
                        } else {
                            $i = Item::where('id', $value->item_id)->first();
                            $customer_item_key = $key;
                            $customer_item_points_value = $args['customer_item_qty'] * $i->points;
                        }
                    } else if ($value->item_id == $args['trader_item_id']) {
                        $customer_new_item_key = $key;
                    }
                }

                if ($trader_item_points_value != $customer_item_points_value) {
                    throw new Exception("The trade cannot be made because it is not balanced");
                } else {
                    $trader->inventory[$trader_item_key]->qty -= $args['trader_item_qty'];
                    $customer->inventory[$customer_item_key]->qty -= $args['customer_item_qty'];
                    $trader->inventory[$trader_new_item_key]->qty += $args['customer_item_qty'];
                    $customer->inventory[$customer_new_item_key]->qty += $args['trader_item_qty'];

                    $trader->inventory[$trader_item_key]->save();
                    $customer->inventory[$customer_item_key]->save();
                    $trader->inventory[$trader_new_item_key]->save();
                    $customer->inventory[$customer_new_item_key]->save();

                    return $trader->inventory->toArray();
                }
            }
        }
    ]
];
