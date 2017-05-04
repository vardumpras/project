<?php

namespace Alcyon\ExempleBundle\EventListener\Hook;

use Alcyon\ExempleBundle\Component\EventDispatcher\Event\HomeFeaturedEvent;
use Doctrine\ORM\EntityManager;

class HomeFeaturedPopulaireListener
{
    private $em;
    
    public function __construct(EntityManager $em) 
    {
        $this->em = $em;
    }
    
    public function renderHomeFeatured(HomeFeaturedEvent $event)
    {
        // Get repository
        $productRepository = $this->em->getRepository('AlcyonExempleBundle:Product');
        
        // Find product
        $products = $productRepository->findByUpdatedAt(new \DateTime('2016-12-21'));
        foreach($products as $product) {
            // Add to event
            $event->addProduct('populaire', $product);
        }
    }
}