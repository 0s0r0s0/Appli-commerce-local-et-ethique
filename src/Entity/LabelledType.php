<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LabelledTypeRepository")
 */
class LabelledType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Good", mappedBy="labelled_type")
     */
    private $goods;

    public function __construct()
    {
        $this->goods = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection|Good[]
     */
    public function getGoods(): Collection
    {
        return $this->goods;
    }

    public function addGood(Good $good): self
    {
        if (!$this->goods->contains($good)) {
            $this->goods[] = $good;
            $good->setLabelledType($this);
        }

        return $this;
    }

    public function removeGood(Good $good): self
    {
        if ($this->goods->contains($good)) {
            $this->goods->removeElement($good);
            // set the owning side to null (unless already changed)
            if ($good->getLabelledType() === $this) {
                $good->setLabelledType(null);
            }
        }

        return $this;
    }
}
