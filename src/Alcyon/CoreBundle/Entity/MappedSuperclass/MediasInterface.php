<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 16/03/2017
 * Time: 16:51
 */

namespace Alcyon\CoreBundle\Entity\MappedSuperclass;


interface MediasInterface
{
    /**
     * Add medias
     *
     * @param \Alcyon\CoreBundle\Entity\Media $media
     *
     * @return mixed
     */
    public function addMedias(\Alcyon\CoreBundle\Entity\Media $media);

    /**
     * Remove medias
     *
     * @param \Alcyon\CoreBundle\Entity\Media $media
     *
     * @return mixed
     */
    public function removeMedias(\Alcyon\CoreBundle\Entity\Media $media);

    /**
     * Get medias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedias();
}