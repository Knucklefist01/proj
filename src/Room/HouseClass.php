<?php

declare(strict_types=1);

namespace App\Room;

/**
 * Class House.
 */
class HouseClass
{
    private ?int $id;
    private ?string $address;
    private ?string $description;
    private ?array $rooms = [];

    public function __construct($id, $address, $description)
    {
        $this->id = $id;
        $this->address = $address;
        $this->description = $description;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function addRoom($room)
    {
        array_push($this->rooms, $room);
    }

    public function getRooms()
    {
        return $this->rooms;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
