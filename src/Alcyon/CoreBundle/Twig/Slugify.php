<?php

namespace Alcyon\CoreBundle\Twig;

use Alcyon\CoreBundle\Service\Slugify as SlugifyService;

class Slugify extends \Twig_Extension
{
	private $slugifyService;

    public function __construct(SlugifyService $slugifyService)
    {
        $this->slugifyService = $slugifyService;
    }

    /**
     * @return SlugifyService
     */
    public function getSlugifyService(): SlugifyService
    {
        return $this->slugifyService;
    }


    public function getFilters()
	{
		return [ new \Twig_SimpleFilter('slugify' , [$this, 'slugify'])];
	}    
    public function getFunctions()
    {
		return [ new \Twig_SimpleFunction('slugify' , [$this, 'slugify'])];
    }

    public function slugify($string)
    {
        return $this->slugifyService->slugify($string);

    }

    public function getName()
    {
        return 'alcyon_core.slugify';
    }
}