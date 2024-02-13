<?php

namespace App\Entity;

use App\Repository\ActivitePhysiqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivitePhysiqueRepository::class)]
class ActivitePhysique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom_activite = null;

    #[ORM\Column(length: 255)]
    private ?string $type_activite = null;

    #[ORM\Column]
    private ?int $calories_brules = null;

    #[ORM\Column]
    private ?int $duree_activite = null;

    #[ORM\Column]
    private ?int $nb_serie = null;

    #[ORM\Column]
    private ?int $nb_rep_serie = null;

    #[ORM\Column]
    private ?int $poids_par_serie = null;

    #[ORM\ManyToOne(inversedBy: 'activites')]
    private ?Objectif $objectif = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomActivite(): ?string
    {
        return $this->Nom_activite;
    }

    public function setNomActivite(string $Nom_activite): static
    {
        $this->Nom_activite = $Nom_activite;

        return $this;
    }

    public function getTypeActivite(): ?string
    {
        return $this->type_activite;
    }

    public function setTypeActivite(string $type_activite): static
    {
        $this->type_activite = $type_activite;

        return $this;
    }

    public function getCaloriesBrules(): ?int
    {
        return $this->calories_brules;
    }

    public function setCaloriesBrules(int $calories_brules): static
    {
        $this->calories_brules = $calories_brules;

        return $this;
    }

    public function getDureeActivite(): ?int
    {
        return $this->duree_activite;
    }

    public function setDureeActivite(int $duree_activite): static
    {
        $this->duree_activite = $duree_activite;

        return $this;
    }

    public function getNbSerie(): ?int
    {
        return $this->nb_serie;
    }

    public function setNbSerie(int $nb_serie): static
    {
        $this->nb_serie = $nb_serie;

        return $this;
    }

    public function getNbRepSerie(): ?int
    {
        return $this->nb_rep_serie;
    }

    public function setNbRepSerie(int $nb_rep_serie): static
    {
        $this->nb_rep_serie = $nb_rep_serie;

        return $this;
    }

    public function getPoidsParSerie(): ?int
    {
        return $this->poids_par_serie;
    }

    public function setPoidsParSerie(int $poids_par_serie): static
    {
        $this->poids_par_serie = $poids_par_serie;

        return $this;
    }

    public function getObjectif(): ?Objectif
    {
        return $this->objectif;
    }

    public function setObjectif(?Objectif $objectif): static
    {
        $this->objectif = $objectif;

        return $this;
    }
}
