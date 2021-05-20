<?php

declare(strict_types=1);

namespace App\Room;

/**
 * Class Bathroom.
 */
class BathroomClass extends RoomClass
{
    protected ?int $sinks;
    protected ?int $toilets;

    public function __construct($id, $houseId, $name, $windows, $floor, $sinks, $toilets)
    {
        $this->sinks = $sinks;
        $this->toilets = $toilets;

        parent::__construct($id, $houseId, $name, $windows, $floor);
    }

    public function getType()
    {
        return "Bathroom";
    }
}
