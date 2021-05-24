<?php

declare(strict_types=1);

namespace App\Room;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use App\Room\RoomClass;

/**
 * Test cases for the controller Debug.
 */
class HouseClassTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateBedroom()
    {
        $controller = new HouseClass(1, "Testgatan 1", "Detta huset är ett test");
        $this->assertInstanceOf("App\Room\HouseClass", $controller);
    }

    public function testGets()
    {
        $house = new HouseClass(1, "Testgatan 1", "Detta huset är ett test");
        $house->addRoom(new RoomClass(1, 1, "Testrum", 2, 1));

        $this->assertEquals($house->getId(), 1);
        $this->assertEquals($house->getAddress(), "Testgatan 1");
        $this->assertEquals($house->getDescription(), "Detta huset är ett test");
        $this->assertEquals(count($house->getRooms()), 1);
    }
}
