<?php

namespace App\Entity;

use App\Repository\ActivitePhysiqueRepository;
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
    #[Assert\NotBlank(message: "Le nom de l'activité ne doit pas etre vide")]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z]+$/",
        message: "le nom de l'activité physique ne doit contenir que des lettres."
    )]
    private ?string $Nom_activite = null;

    #[ORM\Column(length: 255)]
    private ?string $type_activite = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Regex(
        pattern: "/^\d+$/",
        message: "Le nombre de calories brûlées doit contenir uniquement des chiffres."
    )]
    #[Assert\GreaterThan(value: 0, message: "Le nombre de calories brûlées doit être supérieur à zéro.")]
    private ?int $calories_brules = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Regex(
        pattern: "/^\d+$/",
        message: "La duréé doit contenir uniquement des chiffres."
    )]
    private ?int $duree_activite = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Regex(
        pattern: "/^\d+$/",
        message: "le nombre de series doit contenir uniquement des chiffres."
    )]
    #[Assert\GreaterThan(value: 0, message: "Le nombre de série doit être supérieur à zéro.")]
    #[Assert\LessThan(value: 20, message: "Le nombre de series doit inférieur à 20.")]
    private ?int $nb_serie = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Regex(
        pattern: "/^\d+$/",
        message: "le nombre de répétition de series doit contenir uniquement des chiffres."
    )]
    #[Assert\GreaterThan(value: 1, message: "Le nombre de répétition série doit être supérieur à 1.")]
    #[Assert\LessThan(value: 6, message: "Le nombre de répéttion series doit inférieur à 6.")]
    private ?int $nb_rep_serie = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Regex(
        pattern: "/^\d+$/",
        message: "la valeur du poids doit contenir uniquement des chiffres/KGs."
    )]
    #[Assert\GreaterThan(value: 0, message: "la valeur du poids doit être supérieur à 0/KGs.")]
    #[Assert\LessThan(value: 200, message: "la valeur du poids doit inférieur à 200KGs.")]
    private ?int $poids_par_serie = null;

    #[ORM\ManyToOne(inversedBy: 'activites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Objectif $objectif = null;

    #[ORM\Column(length: 255)]
    private ?string $Image_Activite = null;

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

    public function __toString(): string
    {
        return $this->getNomActivite();
    }

    public function getImageActivite(): ?string
    {
        return $this->Image_Activite;
    }

    public function setImageActivite(string $Image_Activite): static
    {
        $this->Image_Activite = $Image_Activite;

        return $this;
    }
    
}
