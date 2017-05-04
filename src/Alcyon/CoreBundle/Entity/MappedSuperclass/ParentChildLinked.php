<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 20/03/2017
 * Time: 15:35
 */

namespace Alcyon\CoreBundle\Entity\MappedSuperclass;

trait ParentChildLinked
{
    abstract public function getChilds();
    abstract public function getParents();

    /**
     * Add a link between parent and child
     *
     * @param mixed $parent
     * @param mixed $child
     */
    public static function addLinkParentChild($parent, $child)
    {
        // Do not add child if allready a parent
        if(!ParentChildLinked::isParentChildLinked($child,$parent)
            && !$parent->getChilds()->contains($child)) {

            $parent->getChilds()->add($child);
            $child->getParents()->add($parent);
        }
    }

    /**
     * If $child and $parent have link
     *
     * @param mixed $parent
     * @param mixed $child
     *
     * @return boolean
     */
    public static function isParentChildLinked($parent, $child)
    {
        $result = $parent->getChilds()->contains($child);

        foreach ($parent->getChilds() as $childItem) {
            $result = $result || ParentChildLinked::isParentChildLinked($childItem, $child);
        }

        return $result;
    }

    /**
     * Remove parent child link
     *
     * @param mixed $parent
     * @param mixed $child
     */
    public static function removeParentChildLink($parent, $child)
    {
        $parent->getChilds()->removeElement($child);
        $child->getParents()->removeElement($parent);

    }
}