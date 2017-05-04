<?php

namespace Alcyon\CoreBundle\Entity\MappedSuperclass;

interface SoftEnableInterface
{
    /**
     * Set enableAt
     *
     * @param  \DateTime|null $enableAt
     *
     * @return mixed
     */
    public function setEnableAt(\DateTime $enableAt = null);

    /**
     * Get enableAt
     *
     * @return \DateTime|null
     */
    public function getEnableAt();
}