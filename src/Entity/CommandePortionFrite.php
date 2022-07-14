<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandePortionFriteRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandePortionFriteRepository::class)]
#[ApiResource]
class CommandePortionFrite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("commande:write:post", "commande:get:collection" )]
    private $id;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandePortionFrites')]
    private $commande;

    #[ORM\ManyToOne(targetEntity: Portionfrite::class, inversedBy: 'commandePortionFrites')]
    #[Groups("commande:write:post", "commande:get:collection" )]
    private $portionfrite;

    #[ORM\Column(type: 'integer')]
    #[Groups("commande:write:post", "commande:get:collection" )]
    private $quantite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getPortionfrite(): ?Portionfrite
    {
        return $this->portionfrite;
    }

    public function setPortionfrite(?Portionfrite $portionfrite): self
    {
        $this->portionfrite = $portionfrite;

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
