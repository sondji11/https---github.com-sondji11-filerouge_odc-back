<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandeBoissonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeBoissonRepository::class)]
#[ApiResource]
class CommandeBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("commande:write:post", "commande:get:collection" )]
    private $id;
    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'commandeBoissons')]
    #[Groups("commande:write:post", "commande:get:collection" )]
    private $boisson;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandeBoissons')]

    private $Commande;

    #[ORM\Column(type: 'integer')]
    #[Groups("commande:write:post", "commande:get:collection" )]
    private $quantite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->Commande;
    }

    public function setCommande(?Commande $Commande): self
    {
        $this->Commande = $Commande;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

   

   

  
}
