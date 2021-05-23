<?php

declare(strict_types=1);

namespace App\Dice;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller Debug.
 */
class YatzyTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateDiceHand()
    {
        $controller = new Yatzy();
        $this->assertInstanceOf("App\Dice\Yatzy", $controller);
    }

    public function testGetData()
    {
        $yatzy = new Yatzy();
        $check = $yatzy->getData();
        $this->assertTrue(is_array($check));
    }

    public function testSetData()
    {
        $yatzy = new Yatzy();
        $yatzy->setData("header", "THIS IS A TEST");
        $check = $yatzy->getData();
        $this->assertEquals($check["header"], "THIS IS A TEST");
    }

    public function testPickPoints()
    {
        $yatzy = new Yatzy();
        $yatzy->pickPoints("Ones", 3);
        $check = $yatzy->getData();
        $this->assertEquals($check["scoreLocked"]["Ones"], 3);
        $yatzy->pickPoints("Twos", 6);
        $yatzy->pickPoints("Threes", 9);
        $yatzy->pickPoints("Fours", 16);
        $yatzy->pickPoints("Fives", 20);
        $yatzy->pickPoints("Sixes", 24);
        $check = $yatzy->getData();
        $this->assertEquals($check["scoreLocked"]["Bonus"], 35);
    }

    public function testThrowDice()
    {
        $yatzy = new Yatzy();
        $check = $yatzy->getData();
        $this->assertEquals($check["throws"], 0);

        $keep = $check["hand"][4];

        $yatzy->throwDice([4]);
        $check = $yatzy->getData();
        $this->assertEquals($check["throws"], 1);
        $this->assertEquals($check["hand"][4], $keep);
    }

    public function testCalcOptions()
    {
        $yatzy = new Yatzy();

        $yatzy->setData("hand", [1,1,1,2,3]);
        $yatzy->calcOptions();
        $check = $yatzy->getData();
        $this->assertTrue($check["scoreOptions"]["Three of a kind"] > 0);
        
        $yatzy->setData("hand", [1,1,1,2,2]);
        $yatzy->calcOptions();
        $check = $yatzy->getData();
        $this->assertTrue($check["scoreOptions"]["Full House"] > 0);
        $this->assertTrue($check["scoreOptions"]["Three of a kind"] > 0);

        $yatzy->setData("hand", [1,1,1,1,2]);
        $yatzy->calcOptions();
        $check = $yatzy->getData();
        $this->assertTrue($check["scoreOptions"]["Four of a kind"] > 0);
        $this->assertTrue($check["scoreOptions"]["Three of a kind"] > 0);

        $yatzy->setData("hand", [1,1,1,1,1]);
        $yatzy->calcOptions();
        $check = $yatzy->getData();
        $this->assertTrue($check["scoreOptions"]["YAHTZEE"] > 0);
        $this->assertTrue($check["scoreOptions"]["Four of a kind"] > 0);
        $this->assertTrue($check["scoreOptions"]["Three of a kind"] > 0);

        $data = [
            "Ones" => 4,
            "Twos" => 6,
            "Threes" => 12,
            "Fours" => 12,
            "Fives" => 20,
            "Sixes" => 18,

            "Sum" => 72,
            "Bonus" => 35,

            "Three of a kind" => 18,
            "Four of a kind" => 18,
            "Full House" => 25,
            "Small straight" => 30,
            "Large straight" => 40,
            "Chance" => 21,
            "YAHTZEE" => 50
        ];
        $yatzy->setData("scoreLocked", $data);
        $yatzy->calcOptions();
        $check = $yatzy->getData();
        $this->assertFalse($check["optionsAvailable"]);
    }

    public function testCheckNumbers()
    {
        $yatzy = new Yatzy();

        $yatzy->setData("hand", [1,1,1,2,3]);
        $data = $yatzy->getData();
        $counts = array_count_values($data["hand"]);
        $yatzy->checkNumbers($counts);

        $check = $yatzy->getData();
        $this->assertEquals($check["scoreOptions"]["Ones"], 3);
        $this->assertEquals($check["scoreOptions"]["Twos"], 2);
        $this->assertEquals($check["scoreOptions"]["Threes"], 3);

        $yatzy->setData("hand", [4,4,5,5,6]);
        $data = $yatzy->getData();
        $counts = array_count_values($data["hand"]);
        $yatzy->checkNumbers($counts);

        $check = $yatzy->getData();
        $this->assertEquals($check["scoreOptions"]["Fours"], 8);
        $this->assertEquals($check["scoreOptions"]["Fives"], 10);
        $this->assertEquals($check["scoreOptions"]["Sixes"], 6);
    }

    public function testCheckStraights()
    {
        $yatzy = new Yatzy();

        $yatzy->checkStraights([1, 2, 3, 4, 1]);
        $check = $yatzy->getData();
        $this->assertEquals($check["scoreOptions"]["Small straight"], 30);

        $yatzy->checkStraights([2, 3, 4, 5, 2]);
        $check = $yatzy->getData();
        $this->assertEquals($check["scoreOptions"]["Small straight"], 30);

        $yatzy->checkStraights([3, 4, 5, 6, 3]);
        $check = $yatzy->getData();
        $this->assertEquals($check["scoreOptions"]["Small straight"], 30);

        $yatzy->checkStraights([1, 2, 3, 4, 5]);
        $check = $yatzy->getData();
        $this->assertEquals($check["scoreOptions"]["Large straight"], 40);

        $yatzy->checkStraights([2, 3, 4, 5, 6]);
        $check = $yatzy->getData();
        $this->assertEquals($check["scoreOptions"]["Large straight"], 40);
    }
}
