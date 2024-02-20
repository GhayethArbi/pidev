<?php

namespace App\Entity;

use App\Repository\ProduitfitnessRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ProduitfitnessRepository::class)]
class Produitfitness
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ReferenceP = null;
    #[ORM\Column(length: 255)]
    private ?string $NameP = null;

    #[ORM\ManyToOne(inversedBy: 'Productsx')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FeedBacks $RefP = null;

    #[ORM\OneToMany(targetEntity: FeedBack::class, mappedBy: 'ref')]
    private Collection $refp;

    public function __construct()
    {
        $this->refp = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameP(): ?string
    {
        return $this->NameP;
    }

    public function setNameP(string $NameP): static
    {
        $this->NameP = $NameP;

        return $this;
    }
   
    public function getReferenceP(): ?string
    {
        return $this->ReferenceP;
    }

    public function setReferenceP(string $ReferenceP): static
    {
        $this->ReferenceP = $ReferenceP;

        return $this;
    }

    public function getRefP(): ?FeedBacks
    {
        return $this->RefP;
    }

    public function setRefP(?FeedBacks $RefP): static
    {
        $this->RefP = $RefP;

        return $this;
    }

    public function addRefp(FeedBack $refp): static
    {
        if (!$this->refp->contains($refp)) {
            $this->refp->add($refp);
            $refp->setRef($this);
        }

        return $this;
    }

    public function removeRefp(FeedBack $refp): static
    {
        if ($this->refp->removeElement($refp)) {
            // set the owning side to null (unless already changed)
            if ($refp->getRef() === $this) {
                $refp->setRef(null);
            }
        }

        return $this;
    }
}
