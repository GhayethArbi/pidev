<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{   #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(targetEntity: Tickets::class, mappedBy: 'userx')]
    private Collection $ticketsx;

    public function __construct()
    {
        $this->ticketsx = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

  
   /* @return Collection<int, Tickets>*/
   
    public function getTicketsx(): Collection
    {
        return $this->ticketsx;
    }

    public function addTicketsx(Tickets $ticketsx): static
    {
        if (!$this->ticketsx->contains($ticketsx)) {
            $this->ticketsx->add($ticketsx);
            $ticketsx->setUserx($this);
        }

        return $this;
    }

    public function removeTicketsx(Tickets $ticketsx): static
    {
        if ($this->ticketsx->removeElement($ticketsx)) {
            // set the owning side to null (unless already changed)
            if ($ticketsx->getUserx() === $this) {
                $ticketsx->setUserx(null);
            }
        }

        return $this;
    }



}


