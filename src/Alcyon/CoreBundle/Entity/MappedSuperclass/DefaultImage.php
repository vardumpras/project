<?php

namespace Alcyon\CoreBundle\Entity\MappedSuperclass;

use Doctrine\ORM\Mapping as ORM;
use Alcyon\CoreBundle\Entity\Media;

/** @ORM\MappedSuperclass */
trait DefaultImage
{
    /**
     * @ORM\ManyToOne(targetEntity="Alcyon\CoreBundle\Entity\Media", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="defaultImage", referencedColumnName="id", nullable=true, onDelete="set null")
     */
    private $defaultImage;

    /**
     * Set defaultImage
     *
     * @param \Alcyon\CoreBundle\Entity\Media $defaultImage
     *
     * @return $this
     */
    public function setDefaultImage(Media $defaultImage = null)
    {
        $this->defaultImage = $defaultImage;

        return $this;
    }

    /**
     * Get defaultImage
     *
     * @return \Alcyon\CoreBundle\Entity\Media|null
     */
    public function getDefaultImage()
    {
        return $this->defaultImage;
    }
}
