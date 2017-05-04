<?php

namespace Alcyon\ExempleBundle\Component\EventDispatcher\Event;

use Alcyon\CoreBundle\Component\EventDispatcher\Event\TemplateEvent;

class HomeFeaturedEvent extends TemplateEvent
{
    private $products;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->products = [];
    }
    
    public function addProduct($title, $product)
    {
        if(!isset($this->products[$title]))
            $this->products[$title] = [];
        
        $this->products[$title][] = $product;
        
        return $this;
    }
 
    public function getProducts()
    {
        return $this->products;
    }
}