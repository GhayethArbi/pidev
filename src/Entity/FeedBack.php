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

    #[ORM\ManyToOne(inversedBy: 'usersx')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $userid = null;

    #[ORM\ManyToOne(inversedBy: 'refp')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produitfitness $ref = null;

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

    public function getUserid(): ?users
    {
        return $this->userid;
    }

    public function setUserid(?users $userid): static
    {
        $this->userid = $userid;

        return $this;
    }

    public function getRef(): ?Produitfitness
    {
        return $this->ref;
    }

    public function setRef(?Produitfitness $ref): static
    {
        $this->ref = $ref;

        return $this;
    }
}
