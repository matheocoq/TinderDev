<?php

namespace App\Entity;

use App\Repository\AmiRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AmiRepository::class)]
class Ami
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'amis')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'relations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $ami = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getAmi(): ?User
    {
        return $this->ami;
    }

    public function setAmi(User $ami): self
    {
        $this->ami = $ami;

        return $this;
    }

    
}
