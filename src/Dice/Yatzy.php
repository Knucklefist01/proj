<?php

declare(strict_types=1);

namespace App\Dice;

use App\Dice\Dice;
use App\Dice\DiceHand;
use App\Dice\GraphicalDice;

/**
 * Class Yatzy.
 */
class Yatzy
{
    private $data = [
        "header" => "Yatzy Game",
        "scoreCategories" => [
            "Ones",
            "Twos",
            "Threes",
            "Fours",
            "Fives",
            "Sixes",

            "Sum",
            "Bonus",

            "Three of a kind",
            "Four of a kind",
            "Full House",
            "Small straight",
            "Large straight",
            "Chance",
            "YAHTZEE"
        ],
        "scoreLocked" => [],
        "scoreOptions" => [],
        "optionsAvailable" => true,
        "scoreTotal" => 0,
        "jsFunctions" => [
            "exampleJS" => ["param1","param2","param3"]
        ],
        "hand" => [],
        "lastKept" => [],
        "throws" => 0,
        "debug" => [],
    ];

    private $dice;

    public function getData(): array
    {
        return $this->data;
    }

    public function setData($key, $value)
    {
        if (array_key_exists($key, $this->data)) {
            $this->data[$key] = $value;
        }
    }

    public function __construct()
    {
        $this->dice = new Dice();
        $this->data["hand"][0] = 1;
        $this->data["hand"][1] = 2;
        $this->data["hand"][2] = 3;
        $this->data["hand"][3] = 4;
        $this->data["hand"][4] = 5;
        $this->data["scoreLocked"]["Sum"] = 0;
        $this->data["scoreLocked"]["Bonus"] = 0;
    }

    public function pickPoints($cat, $points)
    {
        $toSum = [
            "Ones",
            "Twos",
            "Threes",
            "Fours",
            "Fives",
            "Sixes"
        ];

        $this->data["scoreLocked"][$cat] = $points;
        $this->data["scoreOptions"] = [];

        if (in_array($cat, $toSum)) {
            $this->data["scoreLocked"]["Sum"] += $points;
        }

        if ($this->data["scoreLocked"]["Sum"] >= 63) {
            $this->data["scoreLocked"]["Bonus"] = 35;
        }

        $this->data["scoreTotal"] = 0;

        foreach ($this->data["scoreCategories"] as $singleCat) {
            if (isset($this->data["scoreLocked"][$singleCat])) {
                if ($singleCat == "Sum") {
                    continue;
                } else {
                    $this->data["scoreTotal"] += $this->data["scoreLocked"][$singleCat];
                }
            }
        }


        $this->data["throws"] = 0;
    }

    public function throwDice($keep)
    {
        $this->data["lastKept"] = [];

        $handLen = count($this->data["hand"]);

        for ($index = 0; $index < $handLen; $index++) {
            // echo $index," - ", $singleDice, "<br>";
            if (!in_array($index, $keep)) {
                $this->data["hand"][$index] = $this->dice->roll();
            } else {
                array_push($this->data["lastKept"], $index);
                // echo "KEEP <br>";
            }
        }
        $this->data["throws"] += 1;

        $this->calcOptions();
    }

    public function checkNumbers($counts)
    {
        if (isset($counts[1])) {
            $this->data["scoreOptions"]["Ones"] = $counts[1] * 1;
        }
        if (isset($counts[2])) {
            $this->data["scoreOptions"]["Twos"] = $counts[2] * 2;
        }
        if (isset($counts[3])) {
            $this->data["scoreOptions"]["Threes"] = $counts[3] * 3;
        }
        if (isset($counts[4])) {
            $this->data["scoreOptions"]["Fours"] = $counts[4] * 4;
        }
        if (isset($counts[5])) {
            $this->data["scoreOptions"]["Fives"] = $counts[5] * 5;
        }
        if (isset($counts[6])) {
            $this->data["scoreOptions"]["Sixes"] = $counts[6] * 6;
        }
    }

    public function checkStraights($h)
    {
        if (in_array(1, $h) && in_array(2, $h) && in_array(3, $h) && in_array(4, $h)) {
            $this->data["scoreOptions"]["Small straight"] = 30;
        } else if (in_array(2, $h) && in_array(3, $h) && in_array(4, $h) && in_array(5, $h)) {
            $this->data["scoreOptions"]["Small straight"] = 30;
        } else if (in_array(3, $h) && in_array(4, $h) && in_array(5, $h) && in_array(6, $h)) {
            $this->data["scoreOptions"]["Small straight"] = 30;
        }

        if (in_array(1, $h) && in_array(2, $h) && in_array(3, $h) && in_array(4, $h) && in_array(5, $h)) {
            $this->data["scoreOptions"]["Large straight"] = 40;
        } else if (in_array(2, $h) && in_array(3, $h) && in_array(4, $h) && in_array(5, $h) && in_array(6, $h)) {
            $this->data["scoreOptions"]["Large straight"] = 40;
        }
    }

    public function calcOptions()
    {
        $this->data["scoreOptions"] = [];
        $this->data["optionsAvailable"] = true;

        $h = $this->data["hand"];
        $counts = array_count_values($this->data["hand"]);


        $this->checkNumbers($counts);

        $this->checkStraights($h);


        if (count($counts) == 3) {
            // HANDEN BESTÅR AV MINST TRE SIFFROR
            $firstKind = $counts[array_keys($counts)[0]];
            $secondKind = $counts[array_keys($counts)[1]];
            $thirdKind = $counts[array_keys($counts)[2]];

            if ($firstKind == 3 || $secondKind == 3 || $thirdKind == 3) {
                $this->data["scoreOptions"]["Three of a kind"] = array_sum($this->data["hand"]);
            }
        }

        if (count($counts) == 2) {
            // HANDEN BESTÅR AV TVÅ SIFFROR
            $firstKind = $counts[array_keys($counts)[0]];
            $secondKind = $counts[array_keys($counts)[1]];
            if ($firstKind == 3 || $secondKind == 3) {
                $this->data["scoreOptions"]["Full House"] = 25;
            }
            if ($firstKind == 4 || $secondKind == 4) {
                $this->data["scoreOptions"]["Four of a kind"] = array_sum($this->data["hand"]);
            }

            $this->data["scoreOptions"]["Three of a kind"] = array_sum($this->data["hand"]);
        }

        if (count($counts) == 1) {
            // HANDEN BESTÅR AV 1 SIFFRA (YATZY)
            $this->data["scoreOptions"]["YAHTZEE"] = 50;
            $this->data["scoreOptions"]["Four of a kind"] = array_sum($this->data["hand"]);
            $this->data["scoreOptions"]["Three of a kind"] = array_sum($this->data["hand"]);
        }

        $this->data["scoreOptions"]["Chance"] = array_sum($h);


        $this->data["debug"][0] = array_keys($this->data["scoreOptions"]);
        $this->data["debug"][1] = array_keys($this->data["scoreLocked"]);

        $potential = array_keys($this->data["scoreOptions"]);
        $occupied = array_keys($this->data["scoreLocked"]);

        foreach ($potential as $key) {
            if (!in_array($key, $occupied)) {
                $this->data["optionsAvailable"] = true;
                break;
            } else {
                $this->data["optionsAvailable"] = false;
            }
        }
    }
}
