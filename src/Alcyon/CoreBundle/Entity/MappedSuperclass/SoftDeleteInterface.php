<?php

namespace Alcyon\CoreBundle\Entity\MappedSuperclass;

interface SoftDeleteInterface
{
    /**
     * Set deletedAt
     *
     * @param  \DateTime $deletedAt
     *
     * @return mixed
     */
    public function setDeletedAt(\DateTime $deletedAt = null);

    /**
     * Get deletedAt
     *
     * @return \DateTime|null
     */
    public function getDeletedAt();

    /**
     * Set deletedBy
     *
     * @param  \string $deletedBy
     *
     * @return DeletedBy|null
     */
    public function setDeletedBy($deletedBy );

    /**
     * Get deletedBy
     *
     * @return \string
     */
    public function getDeletedBy();
}