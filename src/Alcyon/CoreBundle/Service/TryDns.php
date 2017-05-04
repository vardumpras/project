<?php
namespace Alcyon\CoreBundle\Service;

use Doctrine\Common\Collections\Collection;
use Alcyon\CoreBundle\Service\GetDns;

class TryDns
{
    private $getDns;

    /**
     * @return \Alcyon\CoreBundle\Service\GetDns
     */
    public function getGetDns(): \Alcyon\CoreBundle\Service\GetDns
    {
        return $this->getDns;
    }

	public function __construct(GetDns $getDns) // this is @service_container
    {
        $this->getDns = $getDns;
    }

	public function tryDns(Collection $dnss = null)
	{
		if($dnss == null)
		{
			return true;
		}

		if(0 == $dnss->count())
		{
			return true;
		}

		$defaultDns = $this->getDns->getDns();

		foreach ($dnss->getValues() as $dns) {

			if($dns == $defaultDns) {
				return true;
			}
		}
		return false;
		
	}
}