<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NameP = null;

   

    #[ORM\Column(length: 255)]
    private ?string $Reference = null;

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
   
    public function getReference(): ?string
    {
        return $this->Reference;
    }

    public function setReference(string $Reference): static
    {
        $this->Reference = $Reference;

        return $this;
    }








}
