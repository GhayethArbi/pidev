<?php

namespace App\Entity;

use App\Repository\TicketsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: TicketsRepository::class)]
class Tickets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
  /*  #[ORM\Column(length: 255)]
    private ?string  $title= null;*/

   
    #[ORM\Column(length: 255)]
    private  ?string $number= null;

    #[ORM\ManyToOne(inversedBy: 'ticketsx')]
    private ?User $userx = null;

    #[ORM\ManyToOne(inversedBy: 'nomc')]
    private ?Event $nomx = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;


    public function getId(): ?int
    {
        return $this->id;
    }

   /* public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
*/
    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

   public function getUserx(): ?User
    {
        return $this->userx;
    }

    public function setUserx(?User $userx): static
    {
        $this->userx = $userx;

        return $this;
    }

   public function getNomx(): ?Event
    {
        return $this->nomx;
    }

    public function setNomx(?Event $nomx): static
    {
        $this->nomx = $nomx;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }


    
  
    }









  












