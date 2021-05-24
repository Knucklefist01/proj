<?php

namespace App\Entity;

use App\Repository\BedroomRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BedroomRepository::class)
 */
class Bedroom
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $houseId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $windows;

    /**
     * @ORM\Column(type="integer")
     */
    private $floor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bed;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $enSuite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHouseId(): ?int
    {
        return $this->houseId;
    }

    public function setHouseId(?int $houseId): self
    {
        $this->houseId = $houseId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWindows(): ?int
    {
        return $this->windows;
    }

    public function setWindows(int $windows): self
    {
        $this->windows = $windows;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getBed(): ?string
    {
        return $this->bed;
    }

    public function setBed(string $bed): self
    {
        $this->bed = $bed;

        return $this;
    }

    public function getEnSuite(): ?int
    {
        return $this->enSuite;
    }

    public function setEnSuite(?int $enSuite): self
    {
        $this->enSuite = $enSuite;

        return $this;
    }
}
