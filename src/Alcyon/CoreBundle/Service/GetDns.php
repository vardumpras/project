<?php

namespace Alcyon\CoreBundle\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManager;

class GetDns
{
	private $requestStack;
    private $em;

	public function __construct(RequestStack $requestStack, EntityManager $em)
    {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    /**
     * @return RequestStack
     */
    public function getRequestStack(): RequestStack
    {
        return $this->requestStack;
    }

    /**
     * @return EntityManager
     */
    public function getEm(): EntityManager
    {
        return $this->em;
    }

    public function getDns($domaineName = null)
    {
        // Default domaine name
        if(null == $domaineName)
        	$domaineName = $this->requestStack->getCurrentRequest()->getHttpHost();

        // Get Dns Repository
        $dnsRepository = $this->em->getRepository('AlcyonCoreBundle:Dns');

		// Return Dns entity by current $domaineName
        return $dnsRepository->getDnsByDomaineName($domaineName);
    }
   
}