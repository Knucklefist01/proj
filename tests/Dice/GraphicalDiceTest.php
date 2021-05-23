<?php

declare(strict_types=1);

namespace App\Dice;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller Debug.
 */
class GraphicalDiceTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateDiceHand()
    {
        $controller = new GraphicalDice();
        $this->assertInstanceOf("App\Dice\GraphicalDice", $controller);
    }

    /**
     * Test rolling and getting roll
     */
    public function testGetRoll()
    {
        $dice = new GraphicalDice();
        $res = $dice->roll();
        $truth = "dice" . $res . ".png";
        $check = $dice->getRollFile();
        $this->assertEquals($truth, $check);
    }
}
