<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\ManyToMany(targetEntity: Langage::class, inversedBy: 'utilisateurs')]
    private Collection $langages;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Ami::class , fetch:"EAGER")]
    private Collection $amis;

    #[ORM\OneToMany(mappedBy: 'ami', targetEntity: Ami::class, fetch:"EAGER")]
    private Collection $relations;

    public function __construct()
    {
        $this->langages = new ArrayCollection();
        $this->amis = new ArrayCollection();
        $this->relations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Langage>
     */
    public function getLangages(): Collection
    {
        return $this->langages;
    }

    public function addLangage(Langage $langage): self
    {
        if (!$this->langages->contains($langage)) {
            $this->langages->add($langage);
            $langage->addUtilisateur($this);
        }

        return $this;
    }

    public function removeLangage(Langage $langage): self
    {
        if ($this->langages->removeElement($langage)) {
            $langage->removeUtilisateur($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Ami>
     */
    public function getAmis(): Collection
    {
        return $this->amis;
    }

    public function addAmi(Ami $ami): self
    {
        if (!$this->amis->contains($ami)) {
            $this->amis->add($ami);
            $ami->setUtilisateur($this);
        }

        return $this;
    }

    public function removeAmi(Ami $ami): self
    {
        if ($this->amis->removeElement($ami)) {
            // set the owning side to null (unless already changed)
            if ($ami->getUtilisateur() === $this) {
                $ami->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Relation>
     */
    public function getRelations(): Collection
    {
        return $this->relations;
    }

    public function addRelation(Ami $ami): self
    {
        if (!$this->relations->contains($ami)) {
            $this->relations->add($ami);
            $ami->setAmi($this);
        }

        return $this;
    }

    public function removeRelation(Ami $ami): self
    {
        if ($this->relations->removeElement($ami)) {
            // set the owning side to null (unless already changed)
            if ($ami->getAmi() === $this) {
                $ami->getAmi(null);
            }
        }

        return $this;
    }
}
