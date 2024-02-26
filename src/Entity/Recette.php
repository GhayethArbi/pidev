<?php

namespace App\Entity;
use App\Repository\RecetteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Mime\Message;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message : "Name cannot be blank ! please fill the form  ")]
    #[Assert\Length(min: 5, max:20)]
    #[Assert\Regex(
        pattern: '/^[a-z]+$/i',
        htmlPattern: '^[a-zA-Z]+$',
        message:'The name must contain only letters and spaces',
    )]
    private ?string $name = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Assert\NotBlank(message : "category cannot be blank ! please fill the form ")]
    private ?string $category = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[Assert\Length(min: 20, max:225)]
    #[Assert\NotBlank(message : "Description cannot be blank! please fill the form ")]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
    public function _toString() : string
    {
        return $this->getId();
    }
}
