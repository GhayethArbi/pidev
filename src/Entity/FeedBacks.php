<?php

namespace App\Entity;

use App\Repository\FeedBacksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeedBacksRepository::class)]
class FeedBacks
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

    #[ORM\OneToMany(targetEntity: Produitfitness::class, mappedBy: 'RefP')]
    private Collection $Productsx;

    #[ORM\ManyToOne(inversedBy: 'usersidx')]
    #[ORM\JoinColumn(nullable: false)]
    private ?users $usersid = null;

    public function __construct()
    {
        $this->Productsx = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Produitfitness>
     */
    public function getProductsx(): Collection
    {
        return $this->Productsx;
    }

    public function addProductsx(Produitfitness $productsx): static
    {
        if (!$this->Productsx->contains($productsx)) {
            $this->Productsx->add($productsx);
            $productsx->setRefP($this);
        }

        return $this;
    }

    public function removeProductsx(Produitfitness $productsx): static
    {
        if ($this->Productsx->removeElement($productsx)) {
            // set the owning side to null (unless already changed)
            if ($productsx->getRefP() === $this) {
                $productsx->setRefP(null);
            }
        }

        return $this;
    }

    public function getUsersid(): ?users
    {
        return $this->usersid;
    }

    public function setUsersid(?users $usersid): static
    {
        $this->usersid = $usersid;

        return $this;
    }
}
