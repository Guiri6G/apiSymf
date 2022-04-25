<?php

namespace App\Entity;

use App\Repository\SalonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=SalonRepository::class)
 */
class Salon
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("salon:read")
     * @Groups("barber:read")
     * @Groups("slots:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("salon:read")
     * @Groups("barber:read")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("salon:read")
     * @Groups("barber:read")
     */
    private $localisation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("salon:read")
     */
    private $imageURL;

    /**
     * @ORM\OneToMany(targetEntity=Slots::class, mappedBy="idSalon")
     * @Groups("salon:read")
     */
    private $slots;

    /**
     * @ORM\OneToMany(targetEntity=Barber::class, mappedBy="idSalon")
     */
    private $barbers;

    public function __construct()
    {
        $this->slots = new ArrayCollection();
        $this->barbers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getImageURL(): ?string
    {
        return $this->imageURL;
    }

    public function setImageURL(string $imageURL): self
    {
        $this->imageURL = $imageURL;

        return $this;
    }

    /**
     * @return Collection<int, Slots>
     */
    public function getSlots(): Collection
    {
        return $this->slots;
    }

    public function addSlot(Slots $slot): self
    {
        if (!$this->slots->contains($slot)) {
            $this->slots[] = $slot;
            $slot->setIdSalon($this);
        }

        return $this;
    }

    public function removeSlot(Slots $slot): self
    {
        if ($this->slots->removeElement($slot)) {
            // set the owning side to null (unless already changed)
            if ($slot->getIdSalon() === $this) {
                $slot->setIdSalon(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Barber>
     */
    public function getBarbers(): Collection
    {
        return $this->barbers;
    }

    public function addBarber(Barber $barber): self
    {
        if (!$this->barbers->contains($barber)) {
            $this->barbers[] = $barber;
            $barber->setIdSalon($this);
        }

        return $this;
    }

    public function removeBarber(Barber $barber): self
    {
        if ($this->barbers->removeElement($barber)) {
            // set the owning side to null (unless already changed)
            if ($barber->getIdSalon() === $this) {
                $barber->setIdSalon(null);
            }
        }

        return $this;
    }
}
