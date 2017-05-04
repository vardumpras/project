<?php

namespace Tests\Alcyon\CoreBundle\Entity\MappedSuperclass;

use Alcyon\CoreBundle\Entity\MappedSuperclass\Dnss;
use Alcyon\CoreBundle\Entity\Dns;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class DnssTest extends TestCase
{
    public function testInitDnssAutoCall()
    {
        $dnss = $this->getMockForTrait(Dnss::class);
        $this->assertInstanceOf(Collection::class, $dnss->getDnss());
        $this->assertCount(0, $dnss->getDnss());

        $dns = $this->getMockBuilder(Dns::class)
            ->disableOriginalConstructor()
            ->getMock();
        $dnss = $this->getMockForTrait(Dnss::class);
        $this->assertSame($dnss, $dnss->addDnss($dns));
        $this->assertCount(1, $dnss->getDnss());

        $dnss = $this->getMockForTrait(Dnss::class);
        $this->assertSame($dnss, $dnss->removeDnss($dns));
        $this->assertCount(0, $dnss->getDnss());
    }

    public function testAddAndRemoveMedia()
    {
        $dnss = $this->getMockForTrait(Dnss::class);

        $dns = $this->getMockBuilder(Dns::class)
            ->disableOriginalConstructor()
            ->getMock();

        $dnss->addDnss($dns);
        $this->assertCount(1, $dnss->getDnss());
        // Double add, test
        $dnss->addDnss($dns);
        $this->assertCount(1, $dnss->getDnss());

        //Remove
        $dnsNew = $this->getMockBuilder(Dns::class)
            ->disableOriginalConstructor()
            ->getMock();
        $dnss->removeDnss($dnsNew);
        $this->assertCount(1, $dnss->getDnss());
        foreach ($dnss->getDnss() as $testDns)
            $this->assertSame($dns, $testDns);

        $dnss->addDnss($dnsNew);
        $this->assertCount(2, $dnss->getDnss());

        $dnss->removeDnss($dns);
        $this->assertCount(1, $dnss->getDnss());
        foreach ($dnss->getDnss() as $testDns)
            $this->assertSame($dnsNew, $testDns);
    }
}