<?php

declare(strict_types=1);

namespace App\Dice;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller Debug.
 */
class DiceHandTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateDiceHand()
    {
        $controller = new DiceHand();
        $this->assertInstanceOf("App\Dice\DiceHand", $controller);
    }

    /**
     * Test rolling and getting roll
     */
    public function testGetRoll()
    {
        $hand = new DiceHand();
        $hand->roll();
        $truth = [];
        foreach ($hand->dices as $die) {
            array_push($truth, $die->getLastRoll());
        }
        $check = $hand->getLastRoll();
        $this->assertEquals($truth, $check);
    }
}
