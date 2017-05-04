<?php

namespace Tests\Alcyon\CoreBundle\Service;

use Alcyon\CoreBundle\Service\GetDns;
use Alcyon\CoreBundle\Service\TryDns;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class TryDnsTest extends TestCase
{
    private $getdns;

    /**
     * @var TryDns
     */
    private $tryDns;

    public function setUp()
    {
        $this->getdns = $this->getMockBuilder(GetDns ::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->tryDns = new TryDns($this->getdns);
    }

    public function testConstruct()
    {
        $this->assertSame($this->getdns, $this->tryDns->getGetDns());
    }

    public function testNullDns()
    {
        $this->assertTrue($this->tryDns->tryDns() && $this->tryDns->tryDns(null));
    }

    public function testWithDnsCountZero()
    {
        $dnss = $this->createDnss();

        $this->assertTrue($this->tryDns->tryDns($dnss));
    }

    public function testWithDnsIsValidArrayAndFound()
    {
        $dns = 'dns';
        $dnss = $this->createDnss($dns);

        $this->getdns->expects($this->once())
            ->method('getDns')
            ->will($this->returnValue($dns));

        $this->assertTrue($this->tryDns->tryDns($dnss));
    }

    public function testWithDnsIsNotFound()
    {
        $dns = 'dns';
        $dnss = $this->createDnss($dns);

        $this->getdns->expects($this->once())
            ->method('getDns')
            ->will($this->returnValue('false'));

        $this->assertFalse($this->tryDns->tryDns($dnss));
    }

    private function createDnss($dns = null)
    {
        $dnss = $this->getMockBuilder(Collection ::class)
            ->disableOriginalConstructor()
            ->getMock();

        $dnss->expects($this->once())
            ->method('count')
            ->will($this->returnValue($dns ? 1 : 0));

        if($dns) {
            $dnss->expects($this->once())
                ->method('getValues')
                ->will($this->returnValue([$dns]));
        }

        return $dnss;
    }
}