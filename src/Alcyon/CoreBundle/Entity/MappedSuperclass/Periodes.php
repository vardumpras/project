<?php


namespace Alcyon\CoreBundle\Entity\MappedSuperclass;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks 
 */
trait Periodes
{
    /**
     * @ORM\ManyToMany(targetEntity="Alcyon\CoreBundle\Entity\Periode", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     * @Assert\Valid
     */    
    private $periodes;

    /**
     * Init internal data
     */
    private function initPeriodes()
    {
        $this->periodes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add periode
     *
     * @param \Alcyon\CoreBundle\Entity\Periode $periode
     *
     * @return mixed
     */
    public function addPeriode(\Alcyon\CoreBundle\Entity\Periode $periode)
    {
        if(is_null($this->periodes)) {
            $this->initPeriodes();
        }

        if(!$this->periodes->contains($periode)) {
            $this->periodes[] = $periode;
        }

        return $this;
    }

    /**
     * Remove periode
     *
     * @param \Alcyon\CoreBundle\Entity\Periode $periode
     *
     * @return mixed
     */
    public function removePeriode(\Alcyon\CoreBundle\Entity\Periode $periode)
    {
        if(is_null($this->periodes)) {
            $this->initPeriodes();
        }

        if($this->periodes->contains($periode)) {
            $this->periodes->removeElement($periode);
        }

        return $this;
    }

    /**
     * Get periodes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPeriodes()
    {
        if(is_null($this->periodes)) {
            $this->initPeriodes();
        }

        return $this->periodes;
    }
}
