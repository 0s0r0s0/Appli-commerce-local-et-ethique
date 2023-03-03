<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProducerRepository")
 * @Vich\Uploadable()
 */
class Producer
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
    private $siret;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firm_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firm_adress;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $firm_postal_code;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firm_city;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="producer_image", fileNameProperty="image")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string|null
     */
    private $image;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductionType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $production_type;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Good", mappedBy="producer")
     */
    private $goods;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $phone_number;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $tva_intracom;

    public function __construct()
    {
        $this->goods = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFirmName(): ?string
    {
        return $this->firm_name;
    }

    public function setFirmName(string $firm_name): self
    {
        $this->firm_name = $firm_name;

        return $this;
    }

    public function getFirmAdress(): ?string
    {
        return $this->firm_adress;
    }

    public function setFirmAdress(string $firm_adress): self
    {
        $this->firm_adress = $firm_adress;

        return $this;
    }

    public function getFirmPostalCode(): ?string
    {
        return $this->firm_postal_code;
    }

    public function setFirmPostalCode(string $firm_postal_code): self
    {
        $this->firm_postal_code = $firm_postal_code;

        return $this;
    }

    public function getFirmCity(): ?string
    {
        return $this->firm_city;
    }

    public function setFirmCity(string $firm_city): self
    {
        $this->firm_city = $firm_city;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile|null $imageFile
     * @throws Exception
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;

    }

    public function getProductionType(): ?ProductionType
    {
        return $this->production_type;
    }

    public function setProductionType(?ProductionType $production_type): self
    {
        $this->production_type = $production_type;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

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
            $good->setProducer($this);
        }

        return $this;
    }

    public function removeGood(Good $good): self
    {
        if ($this->goods->contains($good)) {
            $this->goods->removeElement($good);
            // set the owning side to null (unless already changed)
            if ($good->getProducer() === $this) {
                $good->setProducer(null);
            }
        }

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

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
}
