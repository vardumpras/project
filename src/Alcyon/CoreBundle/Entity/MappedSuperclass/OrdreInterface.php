<?php

namespace Alcyon\CoreBundle\Entity\MappedSuperclass;

interface OrdreInterface
{
    /**
     * Set ordre
     *
     * @param integer $ordre
     *
     * @return $this
     */
    public function setOrdre($ordre);

    /**
     * Get ordre
     *
     * @return $this
     */
    public function getOrdre() : int;
}