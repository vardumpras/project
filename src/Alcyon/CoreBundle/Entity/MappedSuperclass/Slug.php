<?php

namespace Alcyon\CoreBundle\Entity\MappedSuperclass;

use Alcyon\CoreBundle\Entity\Entity;

abstract class Slug extends Entity 
{
    /**
     * @var string
     */
    private $slug;

    /**
     * Get title
     *
     * @return string
     */
    public abstract function getTitle();
    
    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}