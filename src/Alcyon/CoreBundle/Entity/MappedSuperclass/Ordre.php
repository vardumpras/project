<?php

namespace Alcyon\CoreBundle\Entity\MappedSuperclass;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
trait Ordre
{
    /**
     * @ORM\Column(name="ordre", type="integer")
     */
    private $ordre = 0;

    /**
     * Set ordre
     *
     * @param integer $ordre
     *
     * @return $this
     */
    public function setOrdre($ordre)
    {
        $this->ordre = (int) $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer
     */
    public function getOrdre() : int
    {
        return $this->ordre;
    }
}
