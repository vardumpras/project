<?php

namespace Tests\Alcyon\CoreBundle\Entity;

use Alcyon\CoreBundle\Entity\Categorie;
use Alcyon\CoreBundle\Entity\MappedSuperclass;
use Alcyon\CoreBundle\Entity\Catalogue;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class CatalogueTest extends TestCase
{
    public function testConstructor()
    {
        $catalogue = new Catalogue();

        // Default value
        $this->assertInstanceOf(Collection::class, $catalogue->getDnss());
        $this->assertCount(0,$catalogue->getDnss());

        $this->assertInstanceOf(Collection::class, $catalogue->getCategories());
        $this->assertCount(0,$catalogue->getCategories());

        // Test add remove categorie
        $categorie =  $this->getMockBuilder(Categorie::class)
            ->disableOriginalConstructor()
            ->getMock();
        $categorie->expects($this->once())
            ->method('setCatalogue')
            ->with($this->equalTo($catalogue));

        $this->assertSame($catalogue, $catalogue->addCategory($categorie));
        $this->assertCount(1,$catalogue->getCategories());

        // Test add twist categorie not have effect
        $this->assertSame($catalogue, $catalogue->addCategory($categorie));
        $this->assertCount(1,$catalogue->getCategories());

        // Test remove not in no have effect
        $categorie = $this->getMockBuilder(Categorie::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->assertSame($catalogue, $catalogue->removeCategory($categorie));
        $this->assertCount(1,$catalogue->getCategories());

        // Remove category
        $catalogue->addCategory($categorie);
        $this->assertCount(2,$catalogue->getCategories());
        $categorie->expects($this->once())
            ->method('setCatalogue')
            ->with($this->equalTo(null));
        $this->assertSame($catalogue,$catalogue->removeCategory($categorie));
        $this->assertCount(1,$catalogue->getCategories());

    }

    public function testExtendsClass()
    {
        $catalogue = new Catalogue();

        $this->assertInstanceOf(MappedSuperclass\BaseCMS::class, $catalogue);
        $this->assertInstanceOf(MappedSuperclass\SoftDeleteInterface::class, $catalogue);
        $this->assertInstanceOf(MappedSuperclass\SoftEnableInterface::class, $catalogue);
        $this->assertInstanceOf(MappedSuperclass\AuthorInterface::class, $catalogue);
        $this->assertInstanceOf(MappedSuperclass\DnssInterface::class, $catalogue);
    }
}