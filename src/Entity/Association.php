<?php

namespace App\Entity;

use App\Repository\AssociationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AssociationRepository::class)
 */
class Association
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="associations")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $siret;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $asso_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $asso_adress;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $asso_postal_code;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $asso_city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $phone_number;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $tva_intracom;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getAssoName(): ?string
    {
        return $this->asso_name;
    }

    public function setAssoName(string $asso_name): self
    {
        $this->asso_name = $asso_name;

        return $this;
    }

    public function getAssoAdress(): ?string
    {
        return $this->asso_adress;
    }

    public function setAssoAdress(string $asso_adress): self
    {
        $this->asso_adress = $asso_adress;

        return $this;
    }

    public function getAssoPostalCode(): ?string
    {
        return $this->asso_postal_code;
    }

    public function setAssoPostalCode(string $asso_postal_code): self
    {
        $this->asso_postal_code = $asso_postal_code;

        return $this;
    }

    public function getAssoCity(): ?string
    {
        return $this->asso_city;
    }

    public function setAssoCity(string $asso_city): self
    {
        $this->asso_city = $asso_city;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getTvaIntracom(): ?string
    {
        return $this->tva_intracom;
    }

    public function setTvaIntracom(string $tva_intracom): self
    {
        $this->tva_intracom = $tva_intracom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
