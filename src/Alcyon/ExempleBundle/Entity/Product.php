<?php

namespace Alcyon\ExempleBundle\Entity;

use Alcyon\CoreBundle\Entity\Categorie;
use Alcyon\CoreBundle\Entity\Entity;
use Alcyon\CoreBundle\Entity\MappedSuperclass;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Table(indexes={@ORM\Index(name="reference", columns={"reference"}),
 *                     @ORM\Index(name="deletedAt", columns={"deletedAt"}),
 *                     @ORM\Index(name="deletedAt", columns={"deletedAt"})})  
 * @ORM\Entity(repositoryClass="Alcyon\ExempleBundle\Repository\ProductRepository")
 */
class Product extends MappedSuperclass\BaseCMS implements MappedSuperclass\SoftDeleteInterface, MappedSuperclass\AuthorInterface
{
    use MappedSuperclass\Author,
        MappedSuperclass\SoftDelete,
        MappedSuperclass\SoftEnable,
        MappedSuperclass\Dnss,
        MappedSuperclass\Medias;
    
    /**
     * @ORM\OneToMany(targetEntity="Attribut", mappedBy="product")
     */
    private $attributs;
    
    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=32)
     * @Assert\NotBlank(message="reference_not_blank")     
     */
    private $reference;
    
    /**
     * @ORM\ManyToMany(targetEntity="Alcyon\CoreBundle\Entity\Categorie", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="categorie_id", referencedColumnName="id", onDelete="set null")
     */
    private $categories;
    
    public function __construct()
    {
        $this->attributs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->initDnss();
        $this->initMedias();
    }
    
    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return BaseCMS
     */
    public function setReference($reference)
    {
        $this->reference = substr($reference,0,32);

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }
    
    /**
     * Add categorie
     *
     * @param \Alcyon\CoreBundle\Entity\Categorie $categorie
     *
     * @return \Alcyon\ExempleBundle\Entity\Product
     */
    public function addCategorie(Categorie $categorie)
    {
        // No duplicate categorie in product
        if(!$this->haveCategorie($categorie)) {
            $this->categories[] = $categorie;
        }
       
        return $this;
    }

    /**
     * Remove categorie
     *
     * @param \Alcyon\CoreBundle\Entity\Categorie $categorie
     */
    public function removeCategorie(Categorie $categorie)
    {
        $this->categories->removeElement($categorie);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }
    
    /**
     * Is child of this categorie
     *
     * @param \Alcyon\CoreBundle\Entity\Categorie $categorie
     *
     * @return boolean
     */
    public function haveCategorie(Categorie $categorie)
    {
        $array = $this->categories->toArray();
        if(in_array($categorie,$array, true)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Add attribut
     *
     * @param \Alcyon\ExempleBundle\Entity\Attribut $attribut
     *
     * @return Catalogue
     */
    public function addAttribut(\Alcyon\ExempleBundle\Entity\Attribut $attribut)
    {
        $this->attributs[] = $attribut;

        return $this;
    }

    /**
     * Remove attribut
     *
     * @param \Alcyon\ExempleBundle\Entity\Attribut $attribut
     */
    public function removeAttribut(\Alcyon\ExempleBundle\Entity\Attribut $attribut)
    {
        $this->attributs->removeElement($attribut);
    }

    /**
     * Get attributs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttributs()
    {
        return $this->attributs;
    }    
    
    /**
     * Get slug of this product
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->getUrl() ? $this->getUrl() : $this->getId().'-'.$this->getTitle();
    } 
    
}
