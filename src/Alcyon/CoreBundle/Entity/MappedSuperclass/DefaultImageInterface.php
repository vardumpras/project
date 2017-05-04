<?php

namespace Alcyon\CoreBundle\Entity\MappedSuperclass;

use Alcyon\CoreBundle\Entity\Media;

interface DefaultImageInterface
{
    /**
     * Set defaultImage
     *
     * @param \Alcyon\CoreBundle\Entity\Media|null $defaultImage
     *
     * @return $this
     */
    public function setDefaultImage(Media $defaultImage = null);

    /**
     * Get defaultImage
     *
     * @return \Alcyon\CoreBundle\Entity\Media|null
     */
    public function getDefaultImage();
}