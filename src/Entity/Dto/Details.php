<?php

namespace App\Entity\Dto;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Burger;
use App\Entity\Menu;
use App\Repository\DetailsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext:['groups' => ['item:getdetails']],
    collectionOperations:[],
    itemOperations:[

        "get"=>[
            'method' => 'get',
            "path"=>"/details/{id}" ,
            'requirements' => ['id' => '\d+'],
            
            ],

            // "put"=>[
            //     'method' => 'put',
            //     "path"=>"/details/{id}" ,
            //     'requirements' => ['id' => '\d+'],
            //     'normalization_context' => ['groups' => ['item:put_details:read']],
            //     ],
    ],
    attributes: ["pagination_items_per_page" => 5]
)]
class Details
{
    // #[ORM\Id]
    #[Groups('item:getdetails')]
    public $id  ;
  
    #[Groups('item:getdetails')]
    public Menu|Burger  $produit;

    #[Groups("item:getdetails")]
    public  $boissons;

    #[Groups("item:getdetails")]
    public  $portionfrites;

    

  
    public function getId(): ?int
    {
        return $this->id;
    }


   

    
}
