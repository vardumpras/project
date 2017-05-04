<?php

namespace Tests\Alcyon\CoreBundle\Entity\MappedSuperclass;

use Alcyon\CoreBundle\Component\Menu\MenuItem;
use Alcyon\CoreBundle\Entity\MappedSuperclass\BaseCMS;
use Alcyon\CoreBundle\Entity\MappedSuperclass;
use Alcyon\CoreBundle\Component\Menu\CreateMenuInterface;
use PHPUnit\Framework\TestCase;

class BaseCMSTest extends TestCase
{
    public function testExtendsClass()
    {
        $basecms = $this->getMockForAbstractClass(BaseCMS::class);

        $this->assertInstanceOf(MappedSuperclass\Slug::class, $basecms);
        $this->assertInstanceOf(MappedSuperclass\OrdreInterface::class, $basecms);
        $this->assertInstanceOf(MappedSuperclass\DefaultImageInterface::class, $basecms);
        $this->assertInstanceOf(CreateMenuInterface::class, $basecms);
    }

    public function testConstructor()
    {
        $basecms = $this->getMockForAbstractClass(BaseCMS::class);

        $this->assertSame(null, $basecms->getTitle());
        $this->assertSame(null, $basecms->getUrl());
        $this->assertSame(null, $basecms->getContent());
        $this->assertSame(null, $basecms->getShortContent());
    }

    /**
     * @dataProvider dataForTestSetTitleProvider
     */
    public function testSetTitle($data, $newData)
    {
        $basecms = $this->getMockForAbstractClass(BaseCMS::class);

        $basecms->setTitle($data);
        $this->assertSame($newData, $basecms->getTitle());
    }

    public function dataForTestSetTitleProvider()
    {
        return [
            ['test', 'Test'],   // Upp fisrt char
            ['test test', 'Test test'], // Up only fist char of first word
            ['test '.implode(',',range(1,100)), substr('Test '.implode(',',range(1,100)),0,255)] // Limit to 255 chars
        ];
    }

    /**
     * @dataProvider dataForTestSetUrlProvider
     */
    public function testSetUrl($data, $newData)
    {
        $basecms = $this->getMockForAbstractClass(BaseCMS::class);

        $basecms->setUrl($data);
        $this->assertSame($newData, $basecms->getUrl());
    }

    public function dataForTestSetUrlProvider()
    {
        return [
            ['tEsT', 'test'], // Str to lower
            ['test '.implode(',',range(1,100)), substr('test '.implode(',',range(1,100)),0,255)] // Limit to 255 chars
        ];
    }

    public function testSetContent()
    {
        $basecms = $this->getMockForAbstractClass(BaseCMS::class);

        $data = implode(',',range(1,10000));
        $basecms->setContent($data);
        $this->assertSame($data, $basecms->getContent());
    }

    /**
     * @dataProvider dataForTestSetShortContentProvider
     */
    public function testSetShortContent($data, $newData)
    {
        $basecms = $this->getMockForAbstractClass(BaseCMS::class);

        $basecms->setShortContent($data);
        $this->assertSame($newData, $basecms->getShortContent());
    }

    public function dataForTestSetShortContentProvider()
    {
        return [
            ['test '.implode(',',range(1,1000)), substr('test '.implode(',',range(1,1000)),0,2048)] // Limit to 2048 chars
        ];
    }

    /**
     * @dataProvider dataForTestSetTitleProvider
     */
    public function testCreateMenuItem($data)
    {
        // Create base cms object
        $basecms = $this->getMockForAbstractClass(BaseCMS::class);
        $basecms->setTitle($data);
        $basecms->setUrl($data);

        // Get menu item
        $menuItem = $basecms->createMenuItem();

        // test menu item
        $this->assertInstanceOf(MenuItem::class, $menuItem);
        $this->assertSame($basecms->getTitle(), $menuItem->getTitle());
        $this->assertSame($basecms->getUrl(), $menuItem->getUrl());
        $this->assertTrue($menuItem->isVisible());
    }
}