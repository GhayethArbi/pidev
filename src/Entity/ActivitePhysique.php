<?php

namespace App\Entity;

use App\Repository\ActivitePhysiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: ActivitePhysiqueRepository::class)]
class ActivitePhysique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z]+$/",
    )]
    private ?string $Nom_Activite = null;

    #[ORM\Column(length: 255)]
    private ?string $Type_Activite = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Regex(
        pattern: "/^\d+$/"
    )]
    #[Assert\GreaterThan(value: 6)]
    #[Assert\LessThan(value: 180)]
    private ?int $Duree_Activite = null;
    
    #[Assert\GreaterThan(value: 6)]
    #[Assert\LessThan(value: 400)]
    #[ORM\Column(nullable: true)]
        private ?int $Calories_Brules = null;
    
    #[ORM\Column(nullable: true)]
    #[Assert\Regex(
        pattern: "/^\d*$/",
    )]
    #[Assert\GreaterThan(value: 0)]
    #[Assert\LessThan(value: 20)]
    private ?int $Nb_Series = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Regex(
        pattern: "/^\d+$/",
    )]
    #[Assert\GreaterThan(value: 1)]
    #[Assert\LessThan(value: 6)]
    private ?int $Nb_Rep_Series = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Regex(
        pattern: "/^\d+$/",
    )]
    #[Assert\GreaterThan(value: 0)]
    #[Assert\LessThan(value: 200)]
    private ?int $Poids_Par_Serie = null;

   // #[Assert\NotBlank(message:'Tu dois choisir une image')]
    #[ORM\Column(length: 255 , nullable :true )]
  
    private ?string $Image_Activite = null;

    #[ORM\ManyToMany(targetEntity: Objectif::class, mappedBy: 'Activites')]
    private Collection $objectifs;

    public function __construct()
    {
        $this->objectifs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomActivite(): ?string
    {
        return $this->Nom_Activite;
    }

    public function setNomActivite(?string $Nom_Activite): static
    {
        $this->Nom_Activite = $Nom_Activite;

        return $this;
    }

    public function getTypeActivite(): ?string
    {
        return $this->Type_Activite;
    }

    public function setTypeActivite(string $Type_Activite): static
    {
        $this->Type_Activite = $Type_Activite;

        return $this;
    }

    public function getDureeActivite(): ?int
    {
        return $this->Duree_Activite;
    }

    public function setDureeActivite(?int $Duree_Activite): static
    {
        $this->Duree_Activite = $Duree_Activite;

        return $this;
    }

    public function getCaloriesBrules(): ?int
    {
        return $this->Calories_Brules;
    }

    public function setCaloriesBrules(?int $Calories_Brules): static
    {
        $this->Calories_Brules = $Calories_Brules;

        return $this;
    }

    public function getNbSeries(): ?int
    {
        return $this->Nb_Series;
    }

    public function setNbSeries(?int $Nb_Series): static
    {
        $this->Nb_Series = $Nb_Series;

        return $this;
    }

    public function getNbRepSeries(): ?int
    {
        return $this->Nb_Rep_Series;
    }

    public function setNbRepSeries(?int $Nb_Rep_Series): static
    {
        $this->Nb_Rep_Series = $Nb_Rep_Series;

        return $this;
    }

    public function getPoidsParSerie(): ?int
    {
        return $this->Poids_Par_Serie;
    }

    public function setPoidsParSerie(?int $Poids_Par_Serie): static
    {
        $this->Poids_Par_Serie = $Poids_Par_Serie;

        return $this;
    }

    public function getImageActivite(): ?string
    {
        return $this->Image_Activite;
    }

    public function setImageActivite(string $Image_Activite): self
    {
        $this->Image_Activite = $Image_Activite;

        return $this;
    }

    /**
     * @return Collection<int, Objectif>
     */
    public function getObjectifs(): Collection
    {
        return $this->objectifs;
    }

    public function addObjectif(Objectif $objectif): static
    {
        if (!$this->objectifs->contains($objectif)) {
            $this->objectifs->add($objectif);
            $objectif->addActivite($this);
        }

        return $this;
    }

    public function removeObjectif(Objectif $objectif): static
    {
        if ($this->objectifs->removeElement($objectif)) {
            $objectif->removeActivite($this);
        }

        return $this;
    }
    public function __toString(): string
    {
       return (string) $this->id;
    }
}
