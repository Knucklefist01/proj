<?php

declare(strict_types=1);

namespace App\Room;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use App\Room\BathroomClass;

/**
 * Test cases for the controller Debug.
 */
class BedroomClassTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateBedroom()
    {
        $controller = new BedroomClass(1, 1, "TEST", 2, 1, "Twin");
        $this->assertInstanceOf("App\Room\BedroomClass", $controller);
    }

    public function testGets()
    {   
        $room = new BedroomClass(1, 1, "TEST", 2, 1, "Twin");

        $this->assertEquals($room->getId(), 1);
        $this->assertEquals($room->getName(), "TEST");
        $this->assertEquals($room->getWindows(), 2);
        $this->assertEquals($room->getFloor(), 1);
        $this->assertEquals($room->getType(), "Bedroom");
        $this->assertEquals($room->getBed(), "Twin");
        $this->assertEquals($room->getEnSuite(), null);
    }

    public function testGetWithEnSuite()
    {   
        $room = new BedroomClass(
            1, 1, "TEST", 2, 1, "Twin",
            new BathroomClass(1, null, "TEST BATHROOM", 2, 1, 2, 1)
        );

        $this->assertInstanceOf("App\Room\BathroomClass", $room->getEnSuite());
    }
}
