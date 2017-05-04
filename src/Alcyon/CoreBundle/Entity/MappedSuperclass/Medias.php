<?php


namespace Alcyon\CoreBundle\Entity\MappedSuperclass;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/** @ORM\MappedSuperclass */
trait Medias
{
    /**
     * @ORM\ManyToMany(targetEntity="Alcyon\CoreBundle\Entity\Media", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @Assert\Valid
     */    
    private $medias;

    /**
     * Init internal data
     */
    private function initMedias()
    {
        $this->medias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add medias
     *
     * @param \Alcyon\CoreBundle\Entity\Media $media
     *
     * @return mixed
     */
    public function addMedias(\Alcyon\CoreBundle\Entity\Media $media)
    {
        if(is_null($this->medias)) {
            $this->initMedias();
        }

        if(!$this->medias->contains($media)) {
            $this->medias[] = $media;
        }

        return $this;
    }

    /**
     * Remove medias
     *
     * @param \Alcyon\CoreBundle\Entity\Media $media
     *
     * @return mixed
     */
    public function removeMedias(\Alcyon\CoreBundle\Entity\Media $media)
    {
        if(is_null($this->medias)) {
            $this->initMedias();
        }

        if($this->medias->contains($media)) {
            $this->medias->removeElement($media);
        }

        return $this;
    }

    /**
     * Get medias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedias()
    {
        if(is_null($this->medias)) {
            $this->initMedias();
        }

        return $this->medias;
    }
}
