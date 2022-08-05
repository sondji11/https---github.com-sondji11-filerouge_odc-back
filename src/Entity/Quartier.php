<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\QuartierRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Cascade;

#[ORM\Entity(repositoryClass: QuartierRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "normalization_context" =>["groups"=>["quartier:read"]]
        ],
        "post"=>[
        
                "denormalization_context" => ["groups"=>["quartier:write"]],
                "normalization_context" => ["groups"=>["quartier:read"]]

                  ]
         ],
    itemOperations:["get"=>
    [
        "method"=>"get",
        "normalization_context"=>["groups"=>["item:quartier_get:read"]]
    ],
    "put"=>[
        "method"=>"put",
        "denormalization_context"=>["groups"=>["item:quartier_put:write"]],
        "normalization_context"=>["groups"=>["item:quartier_put:read"]]

        ]
    ]
)]
class Quartier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    // #[Groups("quartier:write")]

    private $id;
   
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups("zone:write","quartier:write",)]      
    private $libellequartier;
    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'quartiers')]

    private $zone;

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * Get the value of libellequartier
     */ 
    public function getLibellequartier()
    {
        return $this->libellequartier;
    }

    /**
     * Set the value of libellequartier
     *
     * @return  self
     */ 
    public function setLibellequartier($libellequartier)
    {
        $this->libellequartier = $libellequartier;

        return $this;
    }
}
