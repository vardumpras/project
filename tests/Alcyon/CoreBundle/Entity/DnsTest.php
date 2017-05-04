<?php

namespace Tests\Alcyon\CoreBundle\Entity;

use Alcyon\CoreBundle\Entity\Catalogue;
use Alcyon\CoreBundle\Entity\Dns;
use Alcyon\CoreBundle\Entity\Entity as BaseEntity;
use Alcyon\CoreBundle\Entity\MappedSuperclass\SoftDeleteInterface;
use Alcyon\CoreBundle\Entity\Theme;
use PHPUnit\Framework\TestCase;

class DnsTest extends TestCase
{

    public function testGetterSetterMethod()
    {
        $dns = new Dns();

        $dns->setDns('test dns name');
        $this->assertSame('test dns name', $dns->getDns());

        $theme = $this->getMockBuilder(Theme::class)
            ->disableOriginalConstructor()
            ->getMock();
        $dns->setTheme($theme);
        $this->assertSame($theme, $dns->getTheme());

        $catalogue = $this->getMockBuilder(Catalogue::class)
            ->disableOriginalConstructor()
            ->getMock();
        $dns->setCatalogue($catalogue);
        $this->assertSame($catalogue, $dns->getCatalogue());
    }

    public function testExtendsClass()
    {
        $dns = new Dns();

        $this->assertInstanceOf(BaseEntity::class, $dns);
        $this->assertInstanceOf(SoftDeleteInterface::class, $dns);
    }

}