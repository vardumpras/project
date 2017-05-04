<?php

namespace Alcyon\CoreBundle\Entity\MappedSuperclass;

use Alcyon\CoreBundle\Entity\Dns;
use Doctrine\Common\Collections\Collection;

interface DnssInterface
{
    /**
     * Add dnss
     *
     * @param \Alcyon\CoreBundle\Entity\Dns $dns
     *
     * @return Mixed
     */
    public function addDnss(Dns $dns);

    /**
     * Remove dnss
     *
     * @param \Alcyon\CoreBundle\Entity\Dns $dns
     *
     * @return Mixed
     */
    public function removeDnss(Dns $dns);

    /**
     * Get dnss
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDnss() : Collection;
}