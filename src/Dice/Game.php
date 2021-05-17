<?php

declare(strict_types=1);

namespace App\Dice;

use App\Dice\Dice;
use App\Dice\DiceHand;
use App\Dice\GraphicalDice;

/**
 * Class Game.
 */
class Game
{
    private $data = [
        "header" => "Dice",
        "playerHistory" => [],
        "compHistory" => [],
        "playerSum" => 0,
        "compSum" => 0,
        "gameFinished" => false,
        "playerWon" => false,
        "roundHistory" => []
    ];

    private $playerHand;
    private $compHand;


    public function __construct()
    {
        $this->playerHand = new DiceHand();
        $this->compHand = new DiceHand();
    }


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


    public function hasPlayerWon(): bool
    {
        if ($this->data["playerSum"] > 21) {
            return $this->data["playerWon"] = false;
        } else if ($this->data["compSum"] > 21) {
            return $this->data["playerWon"] = true;
        } else if ($this->data["compSum"] >= $this->data["playerSum"]) {
            return $this->data["playerWon"] = false;
        }
        return $this->data["playerWon"] = true;
    }


    public function updateGame(): void
    {
        if ($this->data["gameFinished"]) {
            $this->data["playerWon"] = $this->hasPlayerWon();
        }
        return;
    }


    public function playerStopped(): void
    {
        $this->data["gameFinished"] = true;

        $this->computersTurn();

        $this->updateGame();
    }


    public function computersTurn(): void
    {
        // echo "<br> COMP TURN";
        while ($this->data["compSum"] < $this->data["playerSum"] && $this->data["compSum"] < 21) {
            // echo "<br> SUM: " . $this->data["compSum"];
            $this->throwCompDice(1);
        }
        // echo "<br> COMP FINAL SUM: " . $this->data["compSum"];
    }


    public function throwPlayerDice($amount): void
    {
        $this->playerHand->roll($amount);

        // $res = "";
        $file = "";
        $thisThrow = [];

        for ($i = 0; $i <= ($amount - 1); $i++) {
            $this->data["playerSum"] += $this->playerHand->dices[$i]->getLastRoll();
            $file = "dice" . $this->playerHand->dices[$i]->getLastRoll() . ".png";
            array_push($thisThrow, $file);
        }
        // $res = substr($res, 0, -2) . "<br>";
        array_push($this->data["playerHistory"], $thisThrow);

        //  $this->data["playerHistory"] .= $res;
        $this->updateGame();
    }


    public function throwCompDice($amount): void
    {
        $this->compHand->roll($amount);

        // $res = "";
        $file = "";
        $thisThrow = [];

        for ($i = 0; $i <= ($amount - 1); $i++) {
            $this->data["compSum"] += $this->compHand->dices[$i]->getLastRoll();
            $file = "dice" . $this->compHand->dices[$i]->getLastRoll() . ".png";
            array_push($thisThrow, $file);
        }
        // $res = substr($res, 0, -2) . "<br>";
        array_push($this->data["compHistory"], $thisThrow);

        // echo "<br> Entry: ".$res;
        // $this->data["compHistory"] .= $res;
    }

    public function startNewRound(): void
    {
        array_push($this->data["roundHistory"], [
            "player" => $this->data["playerSum"],
            "computer" => $this->data["compSum"],
            "playerWinner" => $this->data["playerWon"]
            ]);

        $this->data["playerHistory"] = [];
        $this->data["compHistory"] = [];
        $this->data["playerSum"] = 0;
        $this->data["compSum"] = 0;
        $this->data["gameFinished"] = false;
        $this->data["playerWon"] = false;
        return;
    }
}
