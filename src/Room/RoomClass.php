<?php

declare(strict_types=1);

namespace App\Room;

/**
 * Class Room.
 */
class RoomClass
{
    protected ?int $id;
    protected ?int $houseId;
    protected ?string $name;
    protected ?int $windows;
    protected ?int $floor;

    public function __construct($id, $houseId, $name, $windows, $floor)
    {
        $this->id = $id;
        $this->houseId = $houseId;
        $this->name = $name;
        $this->windows = $windows;
        $this->floor = $floor;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getWindows()
    {
        return $this->windows;
    }

    public function getFloor()
    {
        return $this->floor;
    }

    public function getType()
    {
        return "Room";
    }
}
