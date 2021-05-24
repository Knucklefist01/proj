<?php

declare(strict_types=1);

namespace App\Room;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller Debug.
 */
class BathroomClassTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateBedroom()
    {
        $controller = new BathroomClass(1, 1, "TEST", 2, 1, 1, 2);
        $this->assertInstanceOf("App\Room\BathroomClass", $controller);
    }

    public function testGets()
    {
        $room = new BathroomClass(1, 1, "TEST", 2, 1, 1, 2);

        $this->assertEquals($room->getId(), 1);
        $this->assertEquals($room->getName(), "TEST");
        $this->assertEquals($room->getWindows(), 2);
        $this->assertEquals($room->getFloor(), 1);
        $this->assertEquals($room->getType(), "Bathroom");
        $this->assertEquals($room->getSinks(), 1);
        $this->assertEquals($room->getToilets(), 2);
    }
}
