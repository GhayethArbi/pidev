<?php

namespace App\Entity;

use App\Repository\ObjectifRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert ;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObjectifRepository::class)]
class Objectif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThanOrEqual('today', message: "La date de l'objectif doit être aujourd'hui ou ultérieure.")]
    private ?\DateTimeInterface $Date_objectif = null;

    #[ORM\Column(length: 900, nullable: true)]
    private ?string $note = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Le total de duree ne doit pas être vide")]
    #[Assert\PositiveOrZero(message: "La durée totale doit être supérieure ou égale à zéro.")]
    private ?int $total_duree = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Le total des calories ne doit pas être vide")]
    #[Assert\PositiveOrZero(message: "Le total des calories doit être supérieur ou égal à zéro.")]
    private ?int $total_calories = null;

    #[ORM\OneToMany(mappedBy: 'objectif', targetEntity: ActivitePhysique::class)]
    private Collection $activites;

    #[ORM\Column(length: 255)]
    private ?string $Nom_Objectif = null;

    public function __construct()
    {
        $this->activites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getTotalDuree(): ?int
    {
        return $this->total_duree;
    }

    public function setTotalDuree(int $total_duree): static
    {
        $this->total_duree = $total_duree;

        return $this;
    }

    public function getTotalCalories(): ?int
    {
        return $this->total_calories;
    }

    public function setTotalCalories(int $total_calories): static
    {
        $this->total_calories = $total_calories;

        return $this;
    }

    /**
     * @return Collection<int, ActivitePhysique>
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(ActivitePhysique $activite): static
    {
        if (!$this->activites->contains($activite)) {
            $this->activites->add($activite);
            $activite->setObjectif($this);
        }

        return $this;
    }

    public function removeActivite(ActivitePhysique $activite): static
    {
        if ($this->activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getObjectif() === $this) {
                $activite->setObjectif(null);
            }
        }

        return $this;
    }

    public function getDateObjectif(): ?\DateTimeInterface
    {
        return $this->Date_objectif;
    }

    public function setDateObjectif(\DateTimeInterface $Date_objectif): static
    {
        $this->Date_objectif = $Date_objectif;

        return $this;
    }
    public function __toString(): string
    {
        return (string) $this->getId();
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
}
