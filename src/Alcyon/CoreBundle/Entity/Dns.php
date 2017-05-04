<?php

namespace Alcyon\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Alcyon\CoreBundle\Entity\MappedSuperclass;

/**
 * Dns
 *
 * @ORM\Table(name="dns")
 * @ORM\Table(indexes={@ORM\Index(columns={"deletedAt"})})
 * @ORM\Entity(repositoryClass="Alcyon\CoreBundle\Repository\DnsRepository")
 */
class Dns extends Entity implements MappedSuperclass\SoftDeleteInterface
{
    use MappedSuperclass\SoftDelete;

    /**
     * @var string
     *
     * @ORM\Column(name="dns", type="string", length=255, nullable=true)
     */
    private $dns;

    /**
     * @ORM\ManyToOne(targetEntity="Alcyon\CoreBundle\Entity\Theme", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="theme_id", referencedColumnName="id", nullable=true, onDelete="set null")
     */    
    private $theme;
        
    /**
     * @ORM\ManyToOne(targetEntity="Catalogue", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="catalogue_id", referencedColumnName="id", nullable=true, onDelete="set null")
     */
    private $catalogue;
    
    /**
     * Set dns
     *
     * @param string $dns
     *
     * @return dns
     */
    public function setDns($dns)
    {
        $this->dns = $dns;

        return $this;
    }

    /**
     * Get dns
     *
     * @return string
     */
    public function getDns()
    {
        return $this->dns;
    }

    /**
     * Set theme
     *
     * @param \Alcyon\CoreBundle\Entity\Theme $theme
     *
     * @return dns
     */
    public function setTheme(\Alcyon\CoreBundle\Entity\Theme $theme = null)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return \Alcyon\CoreBundle\Entity\Theme
     */
    public function getTheme()
    {
        return $this->theme;
    }
    
    /**
     * Set catalogue
     *
     * @param \Alcyon\CoreBundle\Entity\Catalogue $catalogue
     *
     * @return \Alcyon\CoreBundle\Entity\Catalogue
     */
    public function setCatalogue(\Alcyon\CoreBundle\Entity\Catalogue $catalogue = null)
    {
        $this->catalogue = $catalogue;

        return $this;
    }

    /**
     * Get catalogue
     *
     * @return \Alcyon\CoreBundle\Entity\Catalogue
     */
    public function getCatalogue()
    {
        return $this->catalogue;
    }
    
}
