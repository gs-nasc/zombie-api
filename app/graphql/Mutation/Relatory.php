<?php

use ZombieAPI\Models\Item;
use ZombieAPI\Models\Survivor;

$relatoryMutation = [
    'infectedPercent' => [
        'type' => $relatoryType,
        'resolve' => function () {

            $totalCount = Survivor::get()->count();
            $infectedCount = Survivor::where('infected', 1)->get()->count();

            $parcel = $totalCount / 100;

            $total = 0;
            $index = 0;
            while ($total < $infectedCount) {
                $total = $parcel * $index;
                $index++;
            }

            return array('value' => ($index - 1));
        }
    ],
    'noInfectedPercent' => [
        'type' => $relatoryType,
        'resolve' => function () {

            $totalCount = Survivor::get()->count();
            $noInfectedCount = Survivor::where('infected', 0)->get()->count();

            $parcel = $totalCount / 100;

            $total = 0;
            $index = 0;
            while ($total < $noInfectedCount) {
                $total = $parcel * $index;
                $index++;
            }

            return array('value' => ($index - 1));
        }
    ],
    'mediaOfItems' => [
        'type' => $relatoryType,
        'resolve' => function () {
            $survivors = Survivor::with('inventory')->get();
            $survivorsTotal = $survivors->count();

            $water = 0;
            $food = 0;
            $drug = 0;
            $munition = 0;
            foreach ($survivors as &$survivor) {
                foreach ($survivor->inventory as &$item) {
                    switch ($item->item_id) {
                        case 1:
                            $water += $item->qty;
                            break;
                        case  2:
                            $food += $item->qty;
                            break;
                        case 3:
                            $drug += $item->qty;
                            break;
                        case 4:
                            $munition += $item->qty;
                            break;
                    }
                }
            }

            $waterTotal = $water / $survivorsTotal;
            $foodTotal = $food / $survivorsTotal;
            $drugTotal = $drug / $survivorsTotal;
            $munitionTotal = $munition / $survivorsTotal;

            return (array('value' => json_encode(array('water' => $waterTotal, 'food' => $foodTotal, 'drug' => $drugTotal, 'munition' => $munitionTotal))));
        }
    ],
    'lostPoints' => [
        'type' => $relatoryType,
        'resolve' => function () {
            $survivors = Survivor::where('infected', 1)->with('inventory')->get();

            $totalPoints = 0;

            foreach ($survivors as &$survivor) {
                foreach ($survivor->inventory as &$item) {
                    $i = Item::where('id', $item->item_id)->first();
                    $totalPoints += $i->points * $item->qty;
                }
            }

            return array('value' => $totalPoints);
        }
    ]
];
