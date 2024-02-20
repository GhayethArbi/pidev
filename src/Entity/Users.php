<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(targetEntity: FeedBacks::class, mappedBy: 'usersid')]
    private Collection $usersidx;

    #[ORM\OneToMany(targetEntity: FeedBack::class, mappedBy: 'userid')]
    private Collection $usersx;

    public function __construct()
    {
        $this->usersidx = new ArrayCollection();
        $this->usersx = new ArrayCollection();
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

    /**
     * @return Collection<int, FeedBacks>
     */
    public function getUsersidx(): Collection
    {
        return $this->usersidx;
    }

    public function addUsersidx(FeedBacks $usersidx): static
    {
        if (!$this->usersidx->contains($usersidx)) {
            $this->usersidx->add($usersidx);
            $usersidx->setUsersid($this);
        }

        return $this;
    }

    public function removeUsersidx(FeedBacks $usersidx): static
    {
        if ($this->usersidx->removeElement($usersidx)) {
            // set the owning side to null (unless already changed)
            if ($usersidx->getUsersid() === $this) {
                $usersidx->setUsersid(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FeedBack>
     */
    public function getUsersx(): Collection
    {
        return $this->usersx;
    }

    public function addUsersx(FeedBack $usersx): static
    {
        if (!$this->usersx->contains($usersx)) {
            $this->usersx->add($usersx);
            $usersx->setUserid($this);
        }

        return $this;
    }

    public function removeUsersx(FeedBack $usersx): static
    {
        if ($this->usersx->removeElement($usersx)) {
            // set the owning side to null (unless already changed)
            if ($usersx->getUserid() === $this) {
                $usersx->setUserid(null);
            }
        }

        return $this;
    }
}
