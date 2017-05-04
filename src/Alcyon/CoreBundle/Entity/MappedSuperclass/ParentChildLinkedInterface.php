<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 20/03/2017
 * Time: 15:40
 */

namespace Alcyon\CoreBundle\Entity\MappedSuperclass;

use Doctrine\Common\Collections\Collection;

interface ParentChildLinkedInterface
{
    /**
     * Get child
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChilds() : Collection;

    /**
     * Get parent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParents() : Collection;

    /**
     * Add a link between parent and child
     *
     * @param mixed $parent
     * @param mixed $child
     */
    public static function addLinkParentChild($parent, $child);

    /**
     * If $child and $parent have link
     *
     * @param mixed $parent
     * @param mixed $child
     *
     * @return boolean
     */
    public static function isParentChildLinked($parent, $child);

    /**
     * Remove parent child link
     *
     * @param mixed $parent
     * @param mixed $child
     */
    public static function removeParentChildLink($parent, $child);
}