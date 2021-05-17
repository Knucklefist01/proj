<?php

declare(strict_types=1);

namespace App\Dice;

/**
 * Class DiceHand.
 */
class DiceHand
{
    private $amount;

    public $dices = [];

    public function __construct($number = 2)
    {
        $this->amount = $number;
        for ($i = 0; $i <= $this->amount - 1; $i++) {
            $this->dices[$i] = new Dice();
        }
    }

    public function roll(): void
    {
        for ($i = 0; $i <= $this->amount - 1; $i++) {
            $this->dices[$i]->roll();
        }
    }

    public function getLastRoll()
    {
        $res = [];

        for ($i = 0; $i <= $this->amount - 1; $i++) {
            array_push($res, $this->dices[$i]->getLastRoll());
        }
        return $res;
    }
}
