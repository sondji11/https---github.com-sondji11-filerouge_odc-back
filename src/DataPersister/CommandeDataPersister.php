<?php

namespace App\DataPersister;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\CalculPrixCommandeService;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class CommandeDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $commandecalcul;

    public function __construct(EntityManagerInterface $entityManager,CalculPrixCommandeService $commandecalcul )
    {
        $this->entityManager = $entityManager;
        $this->commandecalcul = $commandecalcul;

        
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Commande;
    }

    public function persist($data, array $context = [])
    {
     if($data instanceof Commande)
         {
            $data->setMontant($this->commandecalcul->calculprix($data));
        }
            
        $this->entityManager->persist($data);
        // dd($data);
        $this->entityManager->flush();

    }

    public function remove($data, array $context = [])
    {
    }
}
