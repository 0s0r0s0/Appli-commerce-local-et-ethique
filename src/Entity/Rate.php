<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RateRepository")
 */
class Rate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UnitType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unit_type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getUnitType(): ?UnitType
    {
        return $this->unit_type;
    }

    public function setUnitType(?UnitType $unit_type): self
    {
        $this->unit_type = $unit_type;

        return $this;
    }
}
