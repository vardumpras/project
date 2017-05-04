<?php

namespace Alcyon\FrontendBundle\Controller;

use Alcyon\CoreBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('AlcyonFrontendBundle:Default:index.html.twig');
    }
}
