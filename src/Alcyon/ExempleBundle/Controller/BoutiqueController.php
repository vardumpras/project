<?php

namespace Alcyon\ExempleBundle\Controller;

use Alcyon\CoreBundle\Controller\Controller;
use Alcyon\ExempleBundle\Component\EventDispatcher\Event;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/")
 */
class BoutiqueController extends Controller
{
    /**
     * @Route("/", name="homepage")   
     * @Template     
     */
     public function indexAction()
    {
        return [];   
    }
    
    /**
     * @Route("/{id}-{slug}",
     *       name="categorie",
     *       requirements={"id"="\d+", "slug"=".+"})
     * @Template     
     */
     public function categorieAction($id, $slug)
    {
        // Get Entity Manager
        $em = $this->getDoctrine();
        
        // Find categorie by id
        $categorieRepository = $em->getRepository('AlcyonCoreBundle:Categorie');
        $categorie = $categorieRepository->findOneById($id);
        
        // Unable to find categorie, get NotFoundHttpException
        if(null == $categorie) {
            throw new NotFoundHttpException('categorie_not_found');
        }
        
        // Slug is wrong, do a permanent "301 redirect" response
        if($slug != $categorie->getSlug()) {
            return $this->redirectToRoute('categorie', ['id' => $id, 'slug' => $categorie->getSlug()], 301);
        }

        // Find products by categorie
        $produitRepository = $em->getRepository('AlcyonExempleBundle:Product');
        $qb = $produitRepository->queryBuilderFindByCategories($categorie);
        
        // Add page and Nb per page
        $qb->setFirstResult(1)
            ->setMaxResults(12);
        $products = new Paginator($qb);

        // Render Response with categorie and produits
        return [ 'categorie' => $categorie, 'products' => $products];   
    }
    
     /**
     * @Route("/hook")   
     * @Template     
     */
     public function hookAction()
    {
        // Dispatch hookExemple event
        $dispatcher = $this->get('alcyon_core.service.hook_dispatcher');
        $event = new Event\EventExemple();
        $dispatcher->dispatch('hookExemple', $event);
        
        return [];   
    }
}
