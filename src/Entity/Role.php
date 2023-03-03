<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $label;

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

    public function getOwnLabel(): ?string
    {
        if  ($result = ( $this->label === 'ROLE_USER' )) {
            $result = 'Utilisateur';
        }
        else if ($result = ( $this->label === 'ROLE_PRODUCER' )) {
            $result = 'Producteur';
        }
        else {
            $result = 'Admin';
        }
        return $result;
    }
}
