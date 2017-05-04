<?php

namespace Tests\Alcyon\CoreBundle\Entity;

use Alcyon\CoreBundle\Component\Menu\MenuItem;
use Alcyon\CoreBundle\Entity\Categorie;
use Alcyon\CoreBundle\Entity\MappedSuperclass\BaseCMS;
use Alcyon\CoreBundle\Entity\MappedSuperclass;
use Alcyon\CoreBundle\Component\Menu\CreateMenuInterface;
use Alcyon\CoreBundle\Entity\Catalogue;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class CategorieTest extends TestCase
{
    public function testExtendsClass()
    {
        $categorie = new Categorie();

        $this->assertInstanceOf(MappedSuperclass\BaseCMS::class, $categorie);
        $this->assertInstanceOf(MappedSuperclass\AuthorInterface::class, $categorie);
        $this->assertInstanceOf(MappedSuperclass\DnssInterface::class, $categorie);
        $this->assertInstanceOf(MappedSuperclass\MediasInterface::class, $categorie);
        $this->assertInstanceOf(MappedSuperclass\SoftEnableInterface::class, $categorie);
        $this->assertInstanceOf(MappedSuperclass\SoftDeleteInterface::class, $categorie);
        $this->assertInstanceOf(CreateMenuInterface::class, $categorie);
    }

    public function testConstructor()
    {
        $categorie = new Categorie();

        // Default value
        $this->assertCount(0,$categorie->getParents());
        $this->assertCount(0,$categorie->getChilds());
    }

    public function testGetSetCatalogue()
    {
        $categorie = new Categorie();

        $this->assertNull($categorie->getCatalogue());

        $catalogue = $this->getMockBuilder(Catalogue::class)
            ->disableOriginalConstructor()
            ->getMock();

        $categorie->setCatalogue($catalogue);
        $this->assertSame($catalogue, $categorie->getCatalogue());
    }

    public function testAddRemoveChild()
    {
        $categorie = new Categorie();

        $child = new Categorie();

        // Test Add
        $categorie->addChild($child);

        $this->assertCount(1, $categorie->getChilds());
        $this->assertCount(0, $categorie->getParents());
        $this->assertCount(1, $child->getParents());
        $this->assertCount(0, $child->getChilds());

        $this->assertTrue($categorie->isChild($child));
        $this->assertTrue($child->isParent($categorie));

        foreach ($categorie->getChilds() as $childToTest)
            $this->assertSame($child, $childToTest);

        foreach ($categorie->getParents() as $parentToTest)
            $this->assertSame($categorie, $parentToTest);

        // Test Add twice, not added
        $categorie->addChild($child);
        $this->assertCount(1, $categorie->getChilds());
        $this->assertCount(0, $categorie->getParents());
        $this->assertCount(1, $child->getParents());
        $this->assertCount(0, $child->getChilds());
        // Test Remove
        $categorie->removeParent($child); // Remove parent, do nothing
        $this->assertCount(1, $categorie->getChilds());
        $this->assertCount(0, $categorie->getParents());
        $this->assertCount(1, $child->getParents());
        $this->assertCount(0, $child->getChilds());

        $categorie->removeChild($child); // Remove child, set to 0
        $this->assertCount(0, $categorie->getChilds());
        $this->assertCount(0, $categorie->getParents());
        $this->assertCount(0, $child->getParents());
        $this->assertCount(0, $child->getChilds());
    }


    public function testAddRemoveParent()
    {
        $categorie = new Categorie();

        $child = new Categorie();

        // Test Add
        $child->addParent($categorie);

        $this->assertCount(1, $categorie->getChilds());
        $this->assertCount(0, $categorie->getParents());
        $this->assertCount(1, $child->getParents());
        $this->assertCount(0, $child->getChilds());

        $this->assertTrue($categorie->isChild($child));
        $this->assertTrue($child->isParent($categorie));

        foreach ($categorie->getChilds() as $childToTest)
            $this->assertSame($child, $childToTest);

        foreach ($categorie->getParents() as $parentToTest)
            $this->assertSame($categorie, $parentToTest);

        // Test Add twice, not added
        $child->addParent($categorie);
        $this->assertCount(1, $categorie->getChilds());
        $this->assertCount(0, $categorie->getParents());
        $this->assertCount(1, $child->getParents());
        $this->assertCount(0, $child->getChilds());

        // Test Remove
        $child->removeChild($categorie); // Remove child, do nothing
        $this->assertCount(1, $categorie->getChilds());
        $this->assertCount(0, $categorie->getParents());
        $this->assertCount(1, $child->getParents());
        $this->assertCount(0, $child->getChilds());


        $child->removeParent($categorie); // Remove parent its ok
        $this->assertCount(0, $categorie->getChilds());
        $this->assertCount(0, $categorie->getParents());
        $this->assertCount(0, $child->getParents());
        $this->assertCount(0, $child->getChilds());
    }

    public function testCreateMenuItem()
    {
        $data = 'test '.implode(',',range(1,100));
        // Create base cms object
        $categorie = new Categorie();
        $categorie->setTitle($data);
        $categorie->setId(123);
        $categorie->setSlug('slug');

        // Get menu item
        $menuItem = $categorie->createMenuItem();

        // test menu item without url
        $this->assertInstanceOf(MenuItem::class, $menuItem);
        $this->assertSame($categorie->getTitle(), $menuItem->getTitle());
        $this->assertSame('123-slug', $menuItem->getUrl());
        $this->assertTrue($menuItem->isVisible());

        // Get menu item
        $categorie->setUrl($data);
        $menuItem = $categorie->createMenuItem();

        // test menu item with url
        $this->assertInstanceOf(MenuItem::class, $menuItem);
        $this->assertSame($categorie->getTitle(), $menuItem->getTitle());
        $this->assertSame($categorie->getUrl(), $menuItem->getUrl());
        $this->assertTrue($menuItem->isVisible());
    }
}