<?php

namespace Alcyon\ExempleBundle\EventListener\ORM;

use Alcyon\CoreBundle\EventListener\EventListener;
use Alcyon\CoreBundle\Entity\Categorie;
use Doctrine\ORM\Event\LifecycleEventArgs;

class CategorieListener extends EventListener
{
    private $router;
    private $slugify;
    
    public function __construct($router, $slugify)
    {
        $this->router = $router;
        $this->slugify = $slugify;
    }

 
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->updateCategorie($entity);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->updateCategorie($entity);
    }
    
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->updateCategorie($entity);
    }

    private function updateCategorie($categorie)
    {
  
        // force  only works for Categorie entities
        if (!$categorie instanceof Categorie) {
            return;
        }
        
        // Not change custom url 
        if(null != $categorie->getUrl()) {
            return;
        }
        
        // Compute slug
        $slug = $this->slugify->slugify($categorie->getTitle());
        
        // Set Url
        $categorie->setUrl($this->router->generate('categorie', ['id'=>$categorie->getId(),
                                                               'slug' => $slug]));
    }    
}