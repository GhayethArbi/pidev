<?php

namespace App\Entity;

use App\Repository\FeedBackRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeedBackRepository::class)]
class FeedBack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $commentaire = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAvis = null;

    #[ORM\Column(length: 255)]
    private ?string $Evaluation = null;

  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getDateAvis(): ?\DateTimeInterface
    {
        return $this->dateAvis;
    }

    public function setDateAvis(\DateTimeInterface $dateAvis): static
    {
        $this->dateAvis = $dateAvis;

        return $this;
    }

    public function getEvaluation(): ?string
    {
        return $this->Evaluation;
    }

    public function setEvaluation(string $Evaluation): static
    {
        $this->Evaluation = $Evaluation;

        return $this;
    }

    
}
