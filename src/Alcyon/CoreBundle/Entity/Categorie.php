<?php

namespace Alcyon\CoreBundle\Entity;

use Alcyon\CoreBundle\Entity\MappedSuperclass;
use Alcyon\CoreBundle\Component\Menu\MenuItem;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Table(indexes={@ORM\Index(columns={"enableAt"}),
 *                     @ORM\Index(columns={"deletedAt"})})
 * @ORM\Entity(repositoryClass="Alcyon\CoreBundle\Repository\CategorieRepository")
 */
class Categorie extends MappedSuperclass\BaseCMS implements
    MappedSuperclass\AuthorInterface,
    MappedSuperclass\DnssInterface,
    MappedSuperclass\MediasInterface,
    MappedSuperclass\SoftEnableInterface,
    MappedSuperclass\SoftDeleteInterface,
    MappedSuperclass\ParentChildLinkedInterface

{
    use MappedSuperclass\Author,
        MappedSuperclass\Dnss,
        MappedSuperclass\Medias,
        MappedSuperclass\SoftDelete,
        MappedSuperclass\SoftEnable,
        MappedSuperclass\ParentChildLinked;
        
    /**
     * @ORM\ManyToOne(targetEntity="Catalogue", inversedBy="categories", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="catalogue_id", referencedColumnName="id", nullable=true, onDelete="set null")
     */
    private $catalogue;

    /**
     * @ORM\ManyToMany(targetEntity="Categorie", mappedBy="parents")
     */
    private $childs;

    /**
     * @ORM\ManyToMany(targetEntity="Categorie", inversedBy="childs", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true, onDelete="set null")
     */
    private $parents;
    
    public function __construct() {
        $this->parents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->childs = new \Doctrine\Common\Collections\ArrayCollection();
    }  

    /**
     * Set catalogue
     *
     * @param \Alcyon\CoreBundle\Entity\Catalogue $catalogue
     *
     * @return \Alcyon\CoreBundle\Entity\Categorie
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

    /**
     * @inheritdoc
     */
    public function getChilds() : Collection
    {
        return $this->childs;
    }

    /**
     * Add child
     *
     * @param \Alcyon\CoreBundle\Entity\Categorie $child
     *
     * @return \Alcyon\CoreBundle\Entity\Categorie
     */
    public function addChild(\Alcyon\CoreBundle\Entity\Categorie $child)
    {
        $this->addLinkParentChild($this, $child);

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Alcyon\CoreBundle\Entity\Categorie $child
     *
     * @return \Alcyon\CoreBundle\Entity\Categorie
     */
    public function removeChild(\Alcyon\CoreBundle\Entity\Categorie $child)
    {
        $this->removeParentChildLink($this,$child);

        return $this;
    }

    /**
     * Is child of this categorie
     *
     * @param \Alcyon\CoreBundle\Entity\Categorie $child
     *
     * @return boolean
     */
    public function isChild(\Alcyon\CoreBundle\Entity\Categorie $child)
    {
        return $this->isParentChildLinked($this, $child);
    }

    /**
     * @inheritdoc
     */
    public function getParents() : Collection
    {
        return $this->parents;
    }

    /**
     * Add parent
     *
     * @param \Alcyon\CoreBundle\Entity\Categorie $parent
     *
     * @return \Alcyon\CoreBundle\Entity\Categorie
     */
    public function addParent(\Alcyon\CoreBundle\Entity\Categorie $parent)
    {
        $this->addLinkParentChild($parent, $this);

        return $this;
    }

    /**
     * Remove parent
     *
     * @param \Alcyon\CoreBundle\Entity\Categorie $parent
     *
     * @return \Alcyon\CoreBundle\Entity\Categorie
     */
    public function removeParent(\Alcyon\CoreBundle\Entity\Categorie $parent)
    {
        $this->removeParentChildLink($parent, $this);

        return $this;
    }

    /**
     * Is parent of this categorie
     *
     * @param \Alcyon\CoreBundle\Entity\Categorie $child
     *
     * @return boolean
     */    
    public function isParent(\Alcyon\CoreBundle\Entity\Categorie $parent)
    {
        return $this->isParentChildLinked($parent, $this);
    }
    
     /**
     * Create MenuItem of this categorie
     *
     * @param \Alcyon\CoreBundle\Entity\Categorie $child
     *
     * @return \Alcyon\CoreBundle\Component\Menu\MenuItem;
     */
    public function createMenuItem() : MenuItem
    {
        $menu = new MenuItem();

        $menu->setTitle($this->getTitle());
        $menu->setUrl($this->getUrl() ? $this->getUrl() : $this->getId() .'-'.$this->getSlug());
        $menu->setVisible(true);
        
        return $menu;
    }    
}