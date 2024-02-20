<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $TitreE = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date_DebutE = null;

    #[ORM\Column(length: 255)]
    private ?string $StatusE = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date_fin_E = null;

    #[ORM\Column(length: 255)]
    private ?string $Localisation_E = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description_E = null;

    #[ORM\Column]
    private ?int $Nbr_max_P = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreE(): ?string
    {
        return $this->TitreE;
    }

    public function setTitreE(string $TitreE): static
    {
        $this->TitreE = $TitreE;

        return $this;
    }

    public function getDateDebutE(): ?\DateTimeInterface
    {
        return $this->Date_DebutE;
    }

    public function setDateDebutE(\DateTimeInterface $Date_DebutE): static
    {
        $this->Date_DebutE = $Date_DebutE;

        return $this;
    }

    public function getStatusE(): ?string
    {
        return $this->StatusE;
    }

    public function setStatusE(string $StatusE): static
    {
        $this->StatusE = $StatusE;

        return $this;
    }

    public function getDateFinE(): ?\DateTimeInterface
    {
        return $this->Date_fin_E;
    }

    public function setDateFinE(\DateTimeInterface $Date_fin_E): static
    {
        $this->Date_fin_E = $Date_fin_E;

        return $this;
    }

    public function getLocalisationE(): ?string
    {
        return $this->Localisation_E;
    }

    public function setLocalisationE(string $Localisation_E): static
    {
        $this->Localisation_E = $Localisation_E;

        return $this;
    }

    public function getDescriptionE(): ?string
    {
        return $this->Description_E;
    }

    public function setDescriptionE(string $Description_E): static
    {
        $this->Description_E = $Description_E;

        return $this;
    }

    public function getNbrMaxP(): ?int
    {
        return $this->Nbr_max_P;
    }

    public function setNbrMaxP(int $Nbr_max_P): static
    {
        $this->Nbr_max_P = $Nbr_max_P;

        return $this;
    }
}
