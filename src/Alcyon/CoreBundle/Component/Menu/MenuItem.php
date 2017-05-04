<?php

namespace Alcyon\CoreBundle\Component\Menu;

use Alcyon\CoreBundle\Entity\MappedSuperclass\ParentChildLinked;
use Alcyon\CoreBundle\Entity\MappedSuperclass\ParentChildLinkedInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class MenuItem implements ParentChildLinkedInterface
{
    use ParentChildLinked;

    public  $attr = [];
    private $title = '';
    private $url = '';
    private $visible = true;
    private $parents ;
    private $childs;
    private $depth = 0;

    public function __construct()
    {
        $this->parents = new ArrayCollection();
        $this->childs = new ArrayCollection();
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return MenuItem
     */
    public function setUrl($url)
    {
        if (!is_string($url)) {
            throw new \InvalidArgumentException();
        }

        $this->url = $url;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getChilds() : Collection
    {
        return $this->childs;
    }

    public function addParent(MenuItem $parent)
    {
        $this->addLinkParentChild($parent, $this);
    }

    /**
     * Have Child
     *
     * @return bool
     */
    public function haveChild(MenuItem $child)
    {
        return $this->isParentChildLinked($this, $child);
    }

    /**
     * Have Parent
     *
     * @return bool
     */
    public function haveParent(MenuItem $parent)
    {
        return $this->isParentChildLinked($parent, $this);
    }

    public function addChild(MenuItem $child)
    {
        $this->addLinkParentChild($this, $child);
    }

    /**
     * @inheritdoc
     */
    public function getParents() : Collection
    {
        return $this->parents;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return MenuItem
     */
    public function setTitle($title)
    {
        if (!is_string($title)) {
            throw new \InvalidArgumentException();
        }
        $this->title = ucfirst($title);

        return $this;
    }

    /**
     * Get visible
     *
     * @return bool
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * Set visible
     *
     * @param bool $visible
     *
     * @return MenuItem
     */
    public function setVisible($visible)
    {
        if (!is_bool($visible)) {
            throw new \InvalidArgumentException();
        }
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get depth
     *
     * @return string
     */
    public function getDepth()
    {
        // Use first parent for depth
        foreach ($this->parents as $parent) {
            $this->depth = $parent->getDepth() + 1;
            break;
        }

        return $this->depth;
    }

    /**
     * Has Child
     *
     * @return bool
     */
    public function hasChild()
    {
        return count($this->childs) > 0;
    }

    /**
     * Has Parent
     *
     * @return bool
     */
    public function hasParent()
    {
        return count($this->parents) > 0;
    }


    public function getMenuByUri($uri)
    {
        if ($uri === $this->getUrl())
            return $this;

        foreach ($this->getChilds() as $child) {
            $result = $child->getMenuByUri($uri);
            if ($result) {
                return $result;
            }
        }

        return null;
    }
}