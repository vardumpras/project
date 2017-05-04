<?php

namespace Alcyon\ExempleBundle\Controller;

use Alcyon\CoreBundle\Controller\Controller;
use Alcyon\ExempleBundle\ListHelper\ProductElement;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/listview")
 */
class ListviewController extends Controller
{
    /**
     * @Route("", name="listview")   
     * @Template     
     */
     public function indexAction(Request $request)
    {
        // Create list
        $list = $this->createListHelper(ProductElement::class, $this->getDoctrine()->getRepository('AlcyonExempleBundle:Product'));
        
        // Handle request
        $list->handleRequest($request);
        
        // Generate response
        return ['list' => $list->createView()];   
    }   
}