<?php

namespace Alcyon\CoreBundle\Service;

use Alcyon\CoreBundle\Entity\Dns;
use Doctrine\ORM\EntityManager;

class GetTheme
{
    protected $em;

    /**
     * @return EntityManager
     */
    public function getEm(): EntityManager
    {
        return $this->em;
    }

	public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

	public function getTheme(Dns $dns = null)
	{
	    if(null == $dns)
	    {
	        $theme = $this->em->getRepository('AlcyonCoreBundle:Theme')->getDefault();

	    } else {
	        $theme = $dns->getTheme();
	    }

	    return $theme;
	}
}