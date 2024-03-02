<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Nom is required')]
    private ?string $TitreE = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\GreaterThanOrEqual("today", message: "Veuillez saisir une date supérieure à la date d'aujourd'hui ")]
    private ?\DateTimeInterface $Date_DebutE = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Status is required')]
    private ?string $StatusE = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\GreaterThanOrEqual(propertyPath:"Date_DebutE", message: "Veuillez saisir une date supérieure à la date debut ")]
    private ?\DateTimeInterface $Date_fin_E = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Adresse is required')]
    private ?string $Localisation_E = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description_E = null;

    #[ORM\Column]
    private ?int $Nbr_max_P = null;

    #[ORM\OneToMany(targetEntity: Tickets::class, mappedBy: 'nomx')]
    private Collection $nomc;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'You should to add image')]
    private ?string $image = null;

    public function __construct()
    {
        $this->nomc = new ArrayCollection();
    }

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

    /*
      @return Collection<int, Tickets>*/
   
    public function getNomc(): Collection
    {
        return $this->nomc;
    }

    public function addNomc(Tickets $nomc): static
    {
        if (!$this->nomc->contains($nomc)) {
            $this->nomc->add($nomc);
            $nomc->setNomx($this);
        }

        return $this;
    }

    public function removeNomc(Tickets $nomc): static
    {
        if ($this->nomc->removeElement($nomc)) {
            // set the owning side to null (unless already changed)
            if ($nomc->getNomx() === $this) {
                $nomc->setNomx(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }
}

