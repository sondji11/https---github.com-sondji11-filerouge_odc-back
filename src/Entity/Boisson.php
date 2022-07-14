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
    #[ORM\ManyToMany(targetEntity: Taille::class, mappedBy: 'boissons')]
    #[Groups('tailles:write:simple','tailles:read:simple','boisson:write',)]
    private $tailles;

    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: CommandeBoisson::class)]
    private $commandeBoissons;

   

    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column(type: 'integer')]
    // private $id;
   

    public function __construct()
    {
        $this->boissons = new ArrayCollection();
        $this->tailles = new ArrayCollection();
        $this->commandeBoissons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Taille>
     */
    public function getTailles(): Collection
    {
        return $this->tailles;
    }

    public function addTaille(Taille $taille): self
    {
        if (!$this->tailles->contains($taille)) {
            $this->tailles[] = $taille;
            $taille->addBoisson($this);
        }

        return $this;
    }

    public function removeTaille(Taille $taille): self
    {
        if ($this->tailles->removeElement($taille)) {
            $taille->removeBoisson($this);
        }

        return $this;
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

   

   
}
