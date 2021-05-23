<?php

declare(strict_types=1);

namespace App\Room;

/**
 * Class Bedroom.
 */
class BedroomClass extends RoomClass
{
    protected ?string $bed; // Twin, Twin XL, Full, Queen, King
    protected $enSuite;

    public function __construct($id, $houseId, $name, $windows, $floor, $bed, $enSuite = null)
    {
        $this->bed = $bed;
        $this->enSuite = $enSuite;

        parent::__construct($id, $houseId, $name, $windows, $floor);
    }

    public function getBed()
    {
        return $this->bed;
    }

    public function getEnSuite()
    {
        return $this->enSuite;
    }

    public function getType()
    {
        return "Bedroom";
    }
}
