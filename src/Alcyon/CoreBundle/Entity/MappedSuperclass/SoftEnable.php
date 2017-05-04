<?php

namespace Alcyon\CoreBundle\Entity\MappedSuperclass;

use Doctrine\ORM\Mapping as ORM;

/*
 * @ORM\MappedSuperclass
 */
trait SoftEnable
{
    /**
     * @var datetime $enableAt
     *
     * @ORM\Column(name="enableAt", type="datetime", nullable=true)
     */
    private $enableAt;
   
    /**
     * Set enableAt
     *
     * @param  \DateTime|null $enableAt
     *
     * @return mixed
     */
    public function setEnableAt(\DateTime $enableAt = null)
    {
        $this->enableAt = $enableAt;

        return $this;
    }
    
    /**
     * Get enableAt
     *
     * @return \DateTime|null
     */
    public function getEnableAt()
    {
        return $this->enableAt;
    }
}
