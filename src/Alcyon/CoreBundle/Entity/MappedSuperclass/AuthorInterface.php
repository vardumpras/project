<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 09/03/2017
 * Time: 17:49
 */

namespace Alcyon\CoreBundle\Entity\MappedSuperclass;


interface AuthorInterface
{
    /**
     * Set updatedAt
     *
     * @param  null|DateTime $updatedAt
     *
     * @return this|\LogicException
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get updatedAt
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt();

    /**
     * Set author
     *
     * @param  null|string $author
     *
     * @return this|\LogicException
     */
    public function setUpdatedBy($author);

    /**
     * Get author
     *
     * @return null|string
     */
    public function getUpdatedBy();
}