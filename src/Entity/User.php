<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Mime\Message;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Unique;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['name'], message: 'Ce nom de catégorie est déjà utilisé.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;//1

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message:"Your email address cannot be empty.")]
    private ?string $email = null;//2

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Your first name cannot be empty.")]
    #[Assert\Length(min:4, minMessage:"Your first name must contain at least {{ limit }} characters.")]
    private ?string $name = null;//3

    #[ORM\Column(length: 255)]
   
    #[Assert\NotBlank(message:"Your last name cannot be empty.")]
    #[Assert\Length(min:4, minMessage:"Your last name must contain at least {{ limit }} characters.")]
    private ?string $lastName = null;//4

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Please select a valid gender.")]
    #[Assert\Choice(choices:['Male','Female'], message:"Please select a valid gender")]
    private ?string $gender = null;//5

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable:true)]
    
    #[Assert\NotBlank(message:"Your birthday cannot be empty.")]
    #[Assert\Range(min:"-80 years", max:"-15 years", minMessage: "You must be at least {{ limit }} years old to register", maxMessage: "You must be at least 15 years old to register")]
    private ?\DateTimeInterface $birthDay = null;//6

    #[ORM\Column]
    #[Assert\NotBlank(message: "Your phone number cannot be empty.")]
    #[Assert\Length(min:8,max:8, minMessage:"Enter a valid cellphone number",maxMessage:"Enter a valid cellphone number")]
    private ?int $phoneNumber = null;//7

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Votre mot de passe ne contient pas {{ limit }} caractères.")]
    #[Assert\Length(min:4, minMessage:"Votre mot de passe ne contient pas {{ limit }} caractères.")]
    private ?string $address = null;//8

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?int $loyalityPoints = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $medicalRecord = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reset_token = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(message:"Votre mot de passe ne contient pas {{ limit }} caractères.")]
    #[Assert\Length(min:8, minMessage:"Votre mot de passe ne contient pas {{limit }} caractères.")]
    private ?string $password = null;//9

    public function getId(): ?int
    {
        return $this->id;
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
    
    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    public function setResetToken(string $reset_token): static
    {
        $this->reset_token = $reset_token;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthDay(): ?\DateTimeInterface
    {
        return $this->birthDay;
    }

    public function setBirthDay(\DateTimeInterface $birthDay): static
    {
        $this->birthDay = $birthDay;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(int $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getLoyalityPoints(): ?int
    {
        return $this->loyalityPoints;
    }

    public function setLoyalityPoints(int $loyalityPoints): static
    {
        $this->loyalityPoints = $loyalityPoints;

        return $this;
    }

    public function getMedicalRecord(): ?string
    {
        return $this->medicalRecord;
    }

    public function setMedicalRecord(?string $medicalRecord): static
    {
        $this->medicalRecord = $medicalRecord;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }
}
