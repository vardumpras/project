<?php

namespace Alcyon\CoreBundle\Component\Menu;

use Alcyon\CoreBundle\Entity\Catalogue;
use Alcyon\CoreBundle\Service\GetDns;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Routing\RouterInterface;

class MenuFactory implements MenuFactoryInterface
{
    private $router;
    private $em;
    private $getDns;

    public function __construct(RouterInterface $router, EntityManager $em, GetDns $getDns)
    {
        $this->router = $router;
        $this->em = $em;
        $this->getDns = $getDns;
    }

    public function getMenu(Catalogue $catalogue = null)
    {
        if(null == $catalogue)
            $catalogue = $this->getDns->getDns()->getCatalogue();

        $repository = $this->em->getRepository('AlcyonCoreBundle:Categorie');
        if($catalogue)
            $listCategories = $repository->findByCatalogueWithParents($catalogue);
        else 
            $listCategories = array();

        $menu = new MenuItem();
        
        $menu->setTitle('home');
        $menu->setUrl($this->router->generate('homepage'));
        $menu->setVisible(false);

        $listMenuCategory = array('0' => $menu);
        foreach ($listCategories as $category) {
            $parents = $category->getParents();

            if (count($parents) == 0)
                $this->addCategoryToMenu($listMenuCategory, $category, null);

            foreach ($parents as $categoryParent) {
                $this->addCategoryToMenu($listMenuCategory, $category, $categoryParent);
            }
        }

        return $menu;
    }

    private function addCategoryToMenu($listMenuCategory, $category, $categoryParent)
    { 
        
        $id = $category->getId();
   
        if (!isset($listMenuCategory[$id])) {
    
            $listMenuCategory[$id] = $category->createMenuItem();
        }

        $menuChild = $listMenuCategory[$id];

        $idParent = 0;
        if ($categoryParent) {
            $idParent = $categoryParent->getId();

            if (!isset($listMenuCategory[$idParent])) {
                $listMenuCategory[$idParent] = $categoryParent->createMenuItem();
            }
        }
        $menuParent = $listMenuCategory[$idParent];

        $menuChild->addParent($menuParent);
    }
}
