<?php

namespace App\Services;

use App\Entity\Commande;
use App\Entity\MenuPortion;
use App\Entity\Portionfrite;
use App\Entity\CommandeBurger;
use App\Entity\CommandeBoisson;
use Doctrine\ORM\EntityManagerInterface;

Class CalculPrixCommandeService
{
    public function calculprix($data)
    {
        $prix=0;
        // if ($data instanceof Portionfrite or $data instanceof Taille)
        // {
        //     $data->setPrix($prix);
            
        // }
     if ($data instanceof Commande) 
        {
            $prix=$data->getZone()->getPrix();

                foreach($data->getCommandeBurgers() as $commandeburgers)
                {
                $prix += $commandeburgers->getBurger()->getPrix()*$commandeburgers->getQuantite();
                }

            foreach($data->getCommandeMenus() as $commandemenus)
                {

                    $prix+=$commandemenus->getMenu()->getPrix()*$commandemenus->getQuantite();
                }

            foreach($data->getCommandePortionFrites() as $commandeportionfrite)
                {
                    $prix+=$commandeportionfrite->getPortionFrite()->getPrix()*$commandeportionfrite->getQuantite();
            
                }

             foreach($data->getCommandeBoissons() as $commandeBoissons)
                {
                    $prix+=$commandeBoissons->getBoisson()->getPrix()*$commandeBoissons->getQuantite();
            
                }
            
        }
                 return $prix;

        }
    }
       


