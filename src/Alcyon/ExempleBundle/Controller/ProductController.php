<?php

namespace Alcyon\ExempleBundle\Controller;

use Alcyon\CoreBundle\Controller\Controller;
use Alcyon\ExempleBundle\Component\EventDispatcher\Event;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/product")
 */
class ProductController extends Controller
{
    
    /**
     * @Route("/addproduct", name="addproduct")    
     * @Template        
     */
     public function addproductAction()
    {
        return [];   
    }
    
    /**
     * @Route("/editproduct/{id}", name="editproduct")   
     * @Template     
     */
     public function editproductAction($id)
    {
        return [];   
    }    
    
    /**
     * @Route("/duplicateproduct/{id}", name="duplicateproduct")   
     * @Template     
     */
     public function duplicateproductAction($id)
    {
        return [];   
    }

    /**
     * @Route("/deleteproduct/{id}", name="deleteproduct")   
     * @Template     
     */
     public function deleteproductAction($id)
    {
        return [];   
    }    
    
}
