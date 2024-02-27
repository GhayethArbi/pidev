<?php

namespace App\Entity;

use App\Repository\ObjectifRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: ObjectifRepository::class)]
class Objectif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom_Objectif = null;

    #[Assert\GreaterThanOrEqual('now', message: "La date de l'objectif doit être aujourd'hui ou ultérieure.")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Objectif = null;
    #[Assert\PositiveOrZero(message: "La calories brules totale doit être supérieure ou égale à zéro.")]
    #[ORM\Column(nullable: true)]
    private ?int $Total_Calories = null;

    #[Assert\PositiveOrZero(message: "La durée totale doit être supérieure ou égale à zéro.")]
    #[ORM\Column(nullable: true)]
    private ?int $Total_Duree = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Note = null;

    #[ORM\ManyToMany(targetEntity: ActivitePhysique::class, inversedBy: 'objectifs')]
    private Collection $Activites;

    public function __construct()
    {
        $this->Activites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomObjectif(): ?string
    {
        return $this->Nom_Objectif;
    }

    public function setNomObjectif(string $Nom_Objectif): static
    {
        $this->Nom_Objectif = $Nom_Objectif;

        return $this;
    }

    public function getDateObjectif(): ?\DateTimeInterface
    {
        return $this->Date_Objectif;
    }

    public function setDateObjectif(\DateTimeInterface $Date_Objectif): static
    {
        $this->Date_Objectif = $Date_Objectif;

        return $this;
    }

    public function getTotalCalories(): ?int
    {
        return $this->Total_Calories;
    }

    public function setTotalCalories(?int $Total_Calories): static
    {
        $this->Total_Calories = $Total_Calories;

        return $this;
    }

    public function getTotalDuree(): ?int
    {
        return $this->Total_Duree;
    }

    public function setTotalDuree(?int $Total_Duree): static
    {
        $this->Total_Duree = $Total_Duree;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->Note;
    }

    public function setNote(?string $Note): static
    {
        $this->Note = $Note;

        return $this;
    }

    /**
     * @return Collection<int, ActivitePhysique>
     */
    public function getActivites(): Collection
    {
        return $this->Activites;
    }

    public function addActivite(ActivitePhysique $activite): static
    {
        if (!$this->Activites->contains($activite)) {
            $this->Activites->add($activite);
        }

        return $this;
    }

    public function removeActivite(ActivitePhysique $activite): static
    {
        $this->Activites->removeElement($activite);

        return $this;
    }
    public function __toString(): string
    {
       return (string) $this->id;
    }

}
