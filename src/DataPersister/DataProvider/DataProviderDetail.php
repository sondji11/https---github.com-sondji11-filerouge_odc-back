<?php
namespace App\DataPersister\DataProvider;

use App\Entity\Dto\Details;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use App\Repository\PortionfriteRepository;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Repository\BoissonRepository;
use App\Repository\BoissonTailleRepository;

class DataProviderDetail implements ItemDataProviderInterface, RestrictedDataProviderInterface
{

    private $burger;
    private  $boisson ;
    private $menu;
    private $portionfrite;
   


    public function __construct(MenuRepository $menuRepo,BurgerRepository $burgersRepo,PortionfriteRepository $portionfriteRepo, BoissonRepository $boissonRepo)
    {
       // dd('ok');
       $this->menu=$menuRepo;
       $this->burger=$burgersRepo; 
       $this->portionfrite=$portionfriteRepo;
       $this->boisson=$boissonRepo;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Details::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?Details
    {
      $menu=$this->menu->findOneBy(['id'=>$id, 'etat'=>true]);
      $burger=$this->burger->findOneBy(['id'=>$id, 'etat'=>true]);


        $details= new Details();
        $details->id=$id;
     
        if($burger==null){
            $details->produit = $menu;
        }

        if($menu ==null){
            $details->produit= $burger;
        }

       

        $details->boissons = $this->boisson->findAll();
        $details->portionfrites= $this->portionfrite->findAll();

        //dd($details);
        return $details;
        

    }
}