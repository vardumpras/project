<?php

namespace Alcyon\CoreBundle\Entity\MappedSuperclass;

use Doctrine\ORM\Mapping as ORM;

/*
 * @ORM\MappedSuperclass
 */
trait SoftDelete
{
    /**
     * @var datetime $deletedAt
     *
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var string $deletedBy
     *
     * @ORM\Column(name="deletedBy", type="string", nullable=true)
     */
    private $deletedBy;

   
    /**
     * Set deletedAt
     *
     * @param  \DateTime $deletedAt
     *
     * @return this
     */
    public function setDeletedAt(\DateTime $deletedAt = null)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
    
    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set deletedBy
     *
     * @param  \string $deletedBy
     *
     * @return this
     */
    public function setDeletedBy($deletedBy )
    {
              
        $this->deletedBy = $deletedBy;

        return $this;
    }
    
    /**
     * Get deletedBy
     *
     * @return \string
     */
    public function getDeletedBy()
    {
        return $this->deletedBy;
    }
}
