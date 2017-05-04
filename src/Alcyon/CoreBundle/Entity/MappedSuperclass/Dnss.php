<?php


namespace Alcyon\CoreBundle\Entity\MappedSuperclass;

use Doctrine\ORM\Mapping as ORM;
use Alcyon\CoreBundle\Entity\Dns;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/** @ORM\MappedSuperclass */
trait Dnss
{
    /**
     * @ORM\ManyToMany(targetEntity="Alcyon\CoreBundle\Entity\Dns", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @Assert\Valid
     */    
    private $dnss;

    /**
     * Init internal data
     */
    private function initDnss()
    {
        $this->dnss = new ArrayCollection();
    }

    /**
     * Add dnss
     *
     * @param \Alcyon\CoreBundle\Entity\Dns $dns
     *
     * @return Media
     */
    public function addDnss(Dns $dns)
    {
        if(is_null($this->dnss))
            $this->initDnss();

        if(!$this->dnss->contains($dns)) {
            $this->dnss[] = $dns;
        }

        return $this;
    }

    /**
     * Remove dnss
     *
     * @param \Alcyon\CoreBundle\Entity\Dns $dns
     */
    public function removeDnss(Dns $dns)
    {
        if(is_null($this->dnss))
            $this->initDnss();

        if($this->dnss->contains($dns)) {
            $this->dnss->removeElement($dns);
        }

        return $this;
    }

    /**
     * Get dnss
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDnss() : Collection
    {
        if(is_null($this->dnss))
            $this->initDnss();

        return $this->dnss;
    }

}
