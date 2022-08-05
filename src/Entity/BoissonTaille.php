<?php

namespace App\Entity;

use App\Repository\BoissonTailleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonTailleRepository::class)]
class BoissonTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("item:getdetails")]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'boissonTailles')]
    #[Groups("item:getdetails")]
    private ?Boisson $boisson = null;

    #[ORM\ManyToOne(inversedBy: 'boissonTailles')]
    #[Groups("item:getdetails")]
    private ?Taille $taille = null;

   

   

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

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

   
}
