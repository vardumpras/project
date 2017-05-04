<?php

namespace Alcyon\ExempleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Alcyon\CoreBundle\Entity\MappedSuperclass;

/**
 * Attribut
 *
 * @ORM\Table(name="attribut")
 * @ORM\Entity(repositoryClass="Alcyon\ExempleBundle\Repository\AttributRepository")
 */
class Attribut extends MappedSuperclass\BaseCMS
{
    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="attributs", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=true, onDelete="set null")
     */
    private $product;
    
    /**
     * @ORM\ManyToOne(targetEntity="AttributType", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="typeAttribut_id", referencedColumnName="id", nullable=true, onDelete="set null")
     */
    private $attributType;
    
    /**
     * Set product
     *
     * @param \Alcyon\ExempleBundle\Entity\Product $product
     *
     * @return \Alcyon\ExempleBundle\Entity\Attribut
     */
    public function setProduct(\Alcyon\ExempleBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Alcyon\ExempleBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
    
    /**
     * Set typeAttribut
     *
     * @param \Alcyon\ExempleBundle\Entity\AttributType $attributType
     *
     * @return \Alcyon\ExempleBundle\Entity\Attribut
     */
    public function setAttributType(\Alcyon\ExempleBundle\Entity\AttributType $attributType = null)
    {
        $this->attributType = $attributType;

        return $this;
    }

    /**
     * Get attributType
     *
     * @return \Alcyon\ExempleBundle\Entity\AttributType
     */
    public function getAttributType()
    {
        return $this->typeAttribut;
    }    
}
