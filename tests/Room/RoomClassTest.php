<?php

declare(strict_types=1);

namespace App\Room;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller Debug.
 */
class RoomClassTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateRoom()
    {
        $controller = new RoomClass(1, 1, "TEST", 2, 1);
        $this->assertInstanceOf("App\Room\RoomClass", $controller);
    }

    /**
     * Test rolling and getting roll
     */
    public function testGets()
    {
        $room = new RoomClass(1, 1, "TEST", 2, 1);

        $this->assertEquals($room->getId(), 1);
        $this->assertEquals($room->getName(), "TEST");
        $this->assertEquals($room->getWindows(), 2);
        $this->assertEquals($room->getFloor(), 1);
        $this->assertEquals($room->getType(), "Room");
    }
}
