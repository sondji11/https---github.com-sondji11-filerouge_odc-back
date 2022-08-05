<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints\Cascade;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" =>
        [
            "method" => "get",
            "security" => "is_granted('ROLE_CLIENT')",
            "security_message" => "Veuillez vous connecter d'abord",
            "normalization_context" => ["groups" => ["commande:get:collection"]]
        ],
        "post" =>
        [
            "method" => "post",
            "denormalization_context" => ["groups" => ["commande:write:post"]],
            "normalization_context" => ["groups" => ["commande:get:collection"]]

        ]

    ],
    itemOperations: [
        "get" =>
        [
            "method" => "get",
            "security" => "is_granted('ROLE_CLIENT')",
            "security_message" => "Veuillez vous connecter d'abord",
            "normalization_context" => ["groups" => ["commande:get:item"]]
        ],
        "put" =>
        [
            "method" => "put",
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez aucun droit pour accéder à cette ressource",
            "normalization_context" => ["groups" => ["commande:read:put"]],
            "denormalization_context" => ["groups" => ["commande:write:put"]]
        ]
    ]
)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("commande:write:post","commande:get:collection",
        "commande:get:item","commande:read:put","commande:write:put",'client:write','client:read:simple')]

    private $id;
    
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups("commande:get:collection",
        "commande:get:item","commande:read:put","commande:write:put")]
    private $numerocommande;
    
    #[Groups("commande:get:collection",
        "commande:get:item","commande:read:put","commande:write:put")]
    #[ORM\Column(type: 'date', nullable: true)]
    private $date;

    #[Groups("commande:get:collection",
    "commande:get:item","commande:read:put","commande:write:put")]
    #[ORM\Column(type: 'string', nullable: true)]
    private $etat;

    #[ORM\Column(type: 'integer', length: 255, nullable: true)]
    #[Groups(["commande:get:collection"    ])]
    private $montant;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    #[Groups("commande:write:post", "commande:get:collection" )]
    private $zone;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes',)]
    private $livraison;
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    // #[Groups( "commande:get:collection" )]
    private $gestionnaire;
    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[Groups("commande:write:post", "commande:get:collection", )]
    private $client;
    #[ORM\OneToMany(mappedBy: 'Commande', targetEntity: CommandeBoisson::class,cascade:["persist"])]
    #[Groups("commande:write:post", "commande:get:collection" )]
    private $commandeBoissons;
    #[Groups("commande:write:post", "commande:get:collection" )]
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeBurger::class,cascade:["persist"])]
    private $commandeBurgers;
    #[Groups("commande:write:post", "commande:get:collection" )]
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeMenu::class ,cascade:["persist"])]
    private $commandeMenus;
    #[Groups("commande:write:post", "commande:get:collection" )]
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandePortionFrite::class ,cascade:["persist"])]
    private $commandePortionFrites;

   
    

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->etat = "En Cours";
        $this->commandeBoissons = new ArrayCollection();
        $this->commandeBurgers = new ArrayCollection();
        $this->commandeMenus = new ArrayCollection();
        $this->commandePortionFrites = new ArrayCollection();
        $this->numerocommande = "NUM".date('ymdhis');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumerocommande(): ?string
    {
        return $this->numerocommande;
    }

    public function setNumerocommande(?string $numerocommande): self
    {
        $this->numerocommande = $numerocommande;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(?string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, CommandeBoisson>
     */
    public function getCommandeBoissons(): Collection
    {
        return $this->commandeBoissons;
    }

    public function addCommandeBoisson(CommandeBoisson $commandeBoisson): self
    {
        if (!$this->commandeBoissons->contains($commandeBoisson)) {
            $this->commandeBoissons[] = $commandeBoisson;
            $commandeBoisson->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeBoisson(CommandeBoisson $commandeBoisson): self
    {
        if ($this->commandeBoissons->removeElement($commandeBoisson)) {
            // set the owning side to null (unless already changed)
            if ($commandeBoisson->getCommande() === $this) {
                $commandeBoisson->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeBurger>
     */
    public function getCommandeBurgers(): Collection
    {
        return $this->commandeBurgers;
    }

    public function addCommandeBurger(CommandeBurger $commandeBurger): self
    {
        if (!$this->commandeBurgers->contains($commandeBurger)) {
            $this->commandeBurgers[] = $commandeBurger;
            $commandeBurger->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeBurger(CommandeBurger $commandeBurger): self
    {
        if ($this->commandeBurgers->removeElement($commandeBurger)) {
            // set the owning side to null (unless already changed)
            if ($commandeBurger->getCommande() === $this) {
                $commandeBurger->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeMenu>
     */
    public function getCommandeMenus(): Collection
    {
        return $this->commandeMenus;
    }

    public function addCommandeMenu(CommandeMenu $commandeMenu): self
    {
        if (!$this->commandeMenus->contains($commandeMenu)) {
            $this->commandeMenus[] = $commandeMenu;
            $commandeMenu->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeMenu(CommandeMenu $commandeMenu): self
    {
        if ($this->commandeMenus->removeElement($commandeMenu)) {
            // set the owning side to null (unless already changed)
            if ($commandeMenu->getCommande() === $this) {
                $commandeMenu->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandePortionFrite>
     */
    public function getCommandePortionFrites(): Collection
    {
        return $this->commandePortionFrites;
    }

    public function addCommandePortionFrite(CommandePortionFrite $commandePortionFrite): self
    {
        if (!$this->commandePortionFrites->contains($commandePortionFrite)) {
            $this->commandePortionFrites[] = $commandePortionFrite;
            $commandePortionFrite->setCommande($this);
        }

        return $this;
    }

    public function removeCommandePortionFrite(CommandePortionFrite $commandePortionFrite): self
    {
        if ($this->commandePortionFrites->removeElement($commandePortionFrite)) {
            // set the owning side to null (unless already changed)
            if ($commandePortionFrite->getCommande() === $this) {
                $commandePortionFrite->setCommande(null);
            }
        }

        return $this;
    }

  

   

   
}
