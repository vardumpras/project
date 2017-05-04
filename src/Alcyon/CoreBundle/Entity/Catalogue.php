<?php

namespace Alcyon\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Alcyon\CoreBundle\Entity\MappedSuperclass;

/**
 * Catalogue
 *
 * @ORM\Table(name="catalogue")
 * @ORM\Table(indexes={@ORM\Index(name="catalogue_enableAt", columns={"enableAt"}),
 *                     @ORM\Index(name="catalogue_deletedAt", columns={"deletedAt"})})
 * @ORM\Entity(repositoryClass="Alcyon\CoreBundle\Repository\CatalogueRepository")
 */
class Catalogue extends MappedSuperclass\BaseCMS implements
    MappedSuperclass\AuthorInterface,
    MappedSuperclass\SoftDeleteInterface,
    MappedSuperclass\SoftEnableInterface,
    MappedSuperclass\DnssInterface

{
    use MappedSuperclass\Author,
        MappedSuperclass\SoftDelete,
        MappedSuperclass\SoftEnable,
        MappedSuperclass\Dnss;

    /**
     * @ORM\OneToMany(targetEntity="Categorie", mappedBy="catalogue")
     */
    private $categories;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add category
     *
     * @param \Alcyon\CoreBundle\Entity\Categorie $category
     *
     * @return Catalogue
     */
    public function addCategory(\Alcyon\CoreBundle\Entity\Categorie $category)
    {
        if(!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setCatalogue($this);
        }

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Alcyon\CoreBundle\Entity\Categorie $category
     */
    public function removeCategory(\Alcyon\CoreBundle\Entity\Categorie $category)
    {
        if($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            $category->setCatalogue(null);
        }

        return $this;
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
}
