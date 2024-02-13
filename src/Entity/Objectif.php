<?php

namespace App\Entity;

use App\Repository\ObjectifRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObjectifRepository::class)]
class Objectif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 900, nullable: true)]
    private ?string $note = null;

    #[ORM\Column]
    private ?int $total_duree = null;

    #[ORM\Column]
    private ?int $total_calories = null;

    #[ORM\OneToMany(mappedBy: 'objectif', targetEntity: ActivitePhysique::class)]
    private Collection $activites;

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
}
