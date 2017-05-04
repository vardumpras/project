<?php

namespace Alcyon\CoreBundle\Twig;

use Alcyon\CoreBundle\Component\Menu\MenuFactory;
use Symfony\Component\HttpFoundation\RequestStack;

class Menu extends \Twig_Extension
{
    private $menuFactory;
    private $requestStack;

    /**
     * @return MenuFactory
     */
    public function getMenuFactory(): MenuFactory
    {
        return $this->menuFactory;
    }

    /**
     * @return RequestStack
     */
    public function getRequestStack(): RequestStack
    {
        return $this->requestStack;
    }
    
    public function __construct(RequestStack $requestStack,
                                MenuFactory $menuFactory)
    {
        $this->menuFactory = $menuFactory;
        $this->requestStack     = $requestStack;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('menu', [$this, 'render'],
                array('is_safe' => ['html'],'needs_environment' => true)),
        );
    }

    public function render(\Twig_Environment $environment, $template, $depth = 0)
    {
        $uri = $this->requestStack->getCurrentRequest()->getPathInfo();

        return $environment->render($template,['menu' =>  $this->menuFactory->getMenu(),
                                                'uri' => $uri,
                                                'depth' => $depth]);
    }

    public function getName()
    {
        return 'alcyon_core.menu';
    }
}