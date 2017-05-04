<?php

namespace Alcyon\CoreBundle\Entity\MappedSuperclass;

use Doctrine\ORM\Mapping as ORM;

/*
 * @ORM\MappedSuperclass 
 */
trait Author
{
    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    private $updatedAt;
    
    /**
     * @var string
     *
     * @ORM\Column(name="updatedBy", type="string", length=255, nullable=true)
     */
    private $updatedBy;    

    /**
     * Set updatedAt
     *
     * @param  \DateTime $updatedAt
     *
     * @return $this|LogicException
     */
    public function setUpdatedAt($updatedAt)
    {
        if(!$updatedAt instanceof \DateTime && null !== $updatedAt)
            throw new \LogicException('Expected null or \DateTime');

        $this->updatedAt = $updatedAt;

        return $this;
    }
    
    /**
     * Get updatedAt
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * Set author
     *
     * @param  null|string $author
     *
     * @return $this|LogicException
     */
    public function setUpdatedBy($author)
    {
        if(!is_string($author) && null !== $author)
            throw new \LogicException('Expected null or string');

        $this->updatedBy = $author;

        return $this;
    }
    /**
     * Get author
     *
     * @return \string
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

}
