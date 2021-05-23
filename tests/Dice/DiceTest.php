<?php

declare(strict_types=1);

namespace App\Dice;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller Debug.
 */
class DiceTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateDice()
    {
        $controller = new Dice();
        $this->assertInstanceOf("App\Dice\Dice", $controller);
    }

    /**
     * Test rolling and getting roll
     */
    public function testGetRoll()
    {
        $dice = new Dice();
        $firstRoll = $dice->roll();
        $lastRoll = $dice->getLastRoll();
        $this->assertEquals($lastRoll, $firstRoll);
    }
}
