<?php

namespace App\Entity;

use App\Repository\SlotsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=SlotsRepository::class)
 */
class Slots
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("slots:read")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Salon::class, inversedBy="slots")
     * @Groups("slots:read")
     */
    private $idSalon;

    /**
     * @ORM\ManyToOne(targetEntity=Barber::class, inversedBy="slots")
     * @Groups("slots:read")
     */
    private $idBarber;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="slots")
     * @Groups("slots:read")
     */
    private $idUser;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("slots:read")
     */
    private $debutRDV;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("slots:read")
     */
    private $finRDV;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdBarber(): ?Barber
    {
        return $this->idBarber;
    }

    public function setIdBarber(?Barber $idBarber): self
    {
        $this->idBarber = $idBarber;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getDebutRDV(): ?string
    {
        return $this->debutRDV;
    }

    public function setDebutRDV(string $debutRDV): self
    {
        $this->debutRDV = $debutRDV;

        return $this;
    }

    public function getFinRDV(): ?string
    {
        return $this->finRDV;
    }

    public function setFinRDV(string $finRDV): self
    {
        $this->finRDV = $finRDV;

        return $this;
    }
}
