<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>
        [
            "method"=>"get",
            "normalization_context" => ['groups' => ['boisson:read']]


        ],
        "post"=>
        [
            "method"=>"post",
            "denormalization_context" => ['groups' => ['collection:post_boissons:read']],
            "normalization_context" => ['groups' => ['boisson:read']]

        ]
    ],
    itemOperations:[
        "get"=>[
            'method' => 'get',
            "path"=>"/boissons/{id}" ,
            'requirements' => ['id' => '\d+'],
            'normalization_context' => ['groups' => ['item:get_boissons']],
            ],

            "put"=>[
                'method' => 'put',
                "path"=>"/boissons/{id}" ,
                'requirements' => ['id' => '\d+'],
                'normalization_context' => ['groups' => ['item:put_boissons:read']],
                ],


    ]


)]
class Boisson extends Produits
{
    
    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: CommandeBoisson::class)]
    private $commandeBoissons;
    #[Groups('item:get_boissons')]
    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: BoissonTaille::class)]
    private  $boissonTailles;

  

    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column(type: 'integer')]
    // private $id;
   

    public function __construct()
    {
        
        $this->commandeBoissons = new ArrayCollection();
        $this->boissonTailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getCommandeBoisson(): ?CommandeBoisson
    {
        return $this->commandeBoisson;
    }

    public function setCommandeBoisson(?CommandeBoisson $commandeBoisson): self
    {
        $this->commandeBoisson = $commandeBoisson;

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
            $commandeBoisson->setBoisson($this);
        }

        return $this;
    }

    public function removeCommandeBoisson(CommandeBoisson $commandeBoisson): self
    {
        if ($this->commandeBoissons->removeElement($commandeBoisson)) {
            // set the owning side to null (unless already changed)
            if ($commandeBoisson->getBoisson() === $this) {
                $commandeBoisson->setBoisson(null);
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
            $boissonTaille->setBoisson($this);
        }

        return $this;
    }

    public function removeBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if ($this->boissonTailles->removeElement($boissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($boissonTaille->getBoisson() === $this) {
                $boissonTaille->setBoisson(null);
            }
        }

        return $this;
    }

   
   

   
}
