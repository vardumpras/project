<?php

namespace Alcyon\ExempleBundle\EventListener\Hook;

use Alcyon\CoreBundle\Component\EventDispatcher\Event\TemplateEvent;
use Alcyon\ExempleBundle\Component\EventDispatcher\Event\HomeFeaturedEvent;

class HomeCenterListener
{
    public function renderHomeCenter(TemplateEvent $event)
    {
        $localEvent = new HomeFeaturedEvent();
        $localEvent->setTemplate($event->getTemplate());
             
        $event->getDispatcher()->dispatch('home.featured', $localEvent);
      
        $products = [];
        foreach($localEvent->getProducts() as $title => $productsList) {
            $products[$title] = $productsList;
        }

        // Render homecenter
        $result = $event->getTemplate()->render('AlcyonExempleBundle:Boutique:homecenter.block.html.twig', [ 'products' => $products]);
        $event->addResult($result);
        
    }
}