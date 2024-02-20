<?php

namespace App\Entity;
use App\Entity\Recette;
use App\Repository\PlanNutritionnelRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PlanNutritionnelRepository::class)]
class PlanNutritionnel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message : "Name cannot be blank ! please fill the form  ")]
    #[Assert\Length(min: 5, max:20)]
    #[Assert\Regex(
        pattern: '/^[a-z]+$/i',
        htmlPattern: '^[a-zA-Z]+$',
        message:'The name must contain only letters and spaces',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne]
    private ?Recette $recettes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getRecettes(): ?Recette
    {
        return $this->recettes;
    }

    public function setRecettes(?Recette $recettes): static
    {
        $this->recettes = $recettes;

        return $this;
    }
}
