<?php

namespace Alcyon\BackendBundle\Controller;

use Alcyon\CoreBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('AlcyonBackendBundle:Default:index.html.twig');
    }
}
