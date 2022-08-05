<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TailleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[

            'method' => 'get',
            'normalization_context' => ['groups' => ['tailles:read:simple']],
        ],

        "post"=>
        [
            'method' => 'post',

            'denormalization_context' => ['groups' => ['menu:write']],

        ]
    ],
    itemOperations:[
        "get","put"
    ]
)]
class Taille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["tailles:read:simple","menu:write","item:getdetails"])]
    private $id;
    #[Groups(["tailles:read:simple","menu:write","item:getdetails"])]
    #[ORM\Column(type: 'float', nullable: true)]
    private $prix;
    #[Groups(["tailles:read:simple","menu:write","item:getdetails"])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $libelle;
    // #[Groups(["tailles:read:simple"])]
   
    // #[Groups(["tailles:read:simple",'item:getdetails' ])]
    // #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'tailles')]
    // private $boissons;
    #[Groups(["item:getdetails"])]
    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: MenuTaille::class)]
    private $menuTailles;

    #[Groups(["item:getdetails"])]
    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: BoissonTaille::class)]
    private  $boissonTailles;

   

    

    public function __construct()
    {
        
        
      
        $this->menuTailles = new ArrayCollection();
        $this->boissonTailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }


   
    

   

    /**
     * @return Collection<int, MenuTaille>
     */
    public function getMenuTailles(): Collection
    {
        return $this->menuTailles;
    }

    public function addMenuTaille(MenuTaille $menuTaille): self
    {
        if (!$this->menuTailles->contains($menuTaille)) {
            $this->menuTailles[] = $menuTaille;
            $menuTaille->setTaille($this);
        }

        return $this;
    }

    public function removeMenuTaille(MenuTaille $menuTaille): self
    {
        if ($this->menuTailles->removeElement($menuTaille)) {
            // set the owning side to null (unless already changed)
            if ($menuTaille->getTaille() === $this) {
                $menuTaille->setTaille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BoissonTaille>
     */
    public function getBoissonTailles(): Collection
    {
        return $this->boissonTailles;
    }

    public function addBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if (!$this->boissonTailles->contains($boissonTaille)) {
            $this->boissonTailles->add($boissonTaille);
            $boissonTaille->setTaille($this);
        }

        return $this;
    }

    public function removeBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if ($this->boissonTailles->removeElement($boissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($boissonTaille->getTaille() === $this) {
                $boissonTaille->setTaille(null);
            }
        }

        return $this;
    }

  
    
}
