<?php

namespace App\Entity;

use App\Repository\BarberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BarberRepository::class)
 */
class Barber
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("barber:read")
     * @Groups("slots:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("barber:read")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("barber:read")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("barber:read")
     */
    private $imageURL;

    /**
     * @ORM\OneToMany(targetEntity=Slots::class, mappedBy="idBarber")
     * @Groups("barber:read")
     */
    private $slots;

    /**
     * @ORM\ManyToOne(targetEntity=Salon::class, inversedBy="barbers")
     * @Groups("barber:read")
     */
    private $idSalon;

    public function __construct()
    {
        $this->slots = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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
            $slot->setIdBarber($this);
        }

        return $this;
    }

    public function removeSlot(Slots $slot): self
    {
        if ($this->slots->removeElement($slot)) {
            // set the owning side to null (unless already changed)
            if ($slot->getIdBarber() === $this) {
                $slot->setIdBarber(null);
            }
        }

        return $this;
    }

    public function getIdSalon(): ?Salon
    {
        return $this->idSalon;
    }

    public function setIdSalon(?Salon $idSalon): self
    {
        $this->idSalon = $idSalon;

        return $this;
    }
}
