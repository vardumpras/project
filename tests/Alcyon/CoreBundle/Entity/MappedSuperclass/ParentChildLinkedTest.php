<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 20/03/2017
 * Time: 15:49
 */

namespace Tests\Alcyon\CoreBundle\Entity\MappedSuperclass;

use Alcyon\CoreBundle\Entity\MappedSuperclass\ParentChildLinked;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class ParentChildLinkedTest extends TestCase
{
    public function testAddLinkParentChild()
    {
        $parentChildLinkedTrait = $this->createParentChildLinkedobject();
        $child  = $this->createParentChildLinkedobject();

        $parentChildLinkedTrait->addLinkParentChild($parentChildLinkedTrait, $child);
        $this->assertCount(1, $parentChildLinkedTrait->getChilds());
        $this->assertCount(1, $child->getParents());

        // Seconde call to addChild, no add twice
        $parentChildLinkedTrait->addLinkParentChild($parentChildLinkedTrait, $child);
        $this->assertCount(1, $parentChildLinkedTrait->getChilds());
        $this->assertCount(1, $child->getParents());

    }

    public function testRemoveParentChildLink()
    {
        $parentChildLinkedTrait = $this->createParentChildLinkedobject();
        $child = $this->createParentChildLinkedobject();

        $parentChildLinkedTrait->addLinkParentChild($parentChildLinkedTrait, $child);
        $this->assertCount(1,$parentChildLinkedTrait->getChilds());
        $this->assertCount(1,$child->getParents());
        $parentChildLinkedTrait->removeParentChildLink($parentChildLinkedTrait, $child);
        $this->assertCount(0,$parentChildLinkedTrait->getChilds());
        $this->assertCount(0,$child->getParents());
    }


    public function testNoAddChildIfIsParent()
    {
        $parentChildLinkedTrait = $this->createParentChildLinkedobject();
        $child = $this->createParentChildLinkedobject();

        $parentChildLinkedTrait->addLinkParentChild($parentChildLinkedTrait, $child);
        $this->assertCount(0, $parentChildLinkedTrait->getParents());
        $this->assertCount(1, $parentChildLinkedTrait->getChilds());
        $this->assertCount(1, $child->getParents());
        $this->assertCount(0, $child->getChilds());

        $parentChildLinkedTrait->addLinkParentChild($child, $parentChildLinkedTrait);
        $this->assertCount(0, $parentChildLinkedTrait->getParents());
        $this->assertCount(1, $parentChildLinkedTrait->getChilds());
        $this->assertCount(1, $child->getParents());
        $this->assertCount(0, $child->getChilds());
    }

    public function testIsParentChildLinkedMethodWithSubchild()
    {
        $parentChildLinkedTrait = $this->createParentChildLinkedobject();
        $child = $this->createParentChildLinkedobject();
        $subchild = $this->createParentChildLinkedobject();

        // Default = false
        $this->assertFalse($parentChildLinkedTrait->isParentChildLinked($parentChildLinkedTrait, $child));

        // Add child = true
        $parentChildLinkedTrait->addLinkParentChild($parentChildLinkedTrait, $child);
        $this->assertTrue($parentChildLinkedTrait->isParentChildLinked($parentChildLinkedTrait, $child));

        // Add sub child to child and check parent
        $parentChildLinkedTrait->addLinkParentChild($child, $subchild);
        $this->assertTrue($parentChildLinkedTrait->isParentChildLinked($parentChildLinkedTrait, $subchild));
    }

    private function createParentChildLinkedobject()
    {
        $object = $this->getMockForTrait(ParentChildLinked::class);

        // Define getParents() methode
        $object->expects($this->any())
            ->method('getParents')
            ->will($this->returnValue(new ArrayCollection()));

        // Define getChilds() methode
        $object->expects($this->any())
            ->method('getChilds')
            ->will($this->returnValue(new ArrayCollection()));

        return $object;
    }
}