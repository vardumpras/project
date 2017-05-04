<?php

namespace Tests\Alcyon\CoreBundle\Service;

use Alcyon\CoreBundle\Repository\DnsRepository;
use Alcyon\CoreBundle\Service\GetDns;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class GetDnsTest extends TestCase
{
    public function testConstruct()
    {
        $requestStack = $this->getMockBuilder(RequestStack ::class)
            ->disableOriginalConstructor()
            ->getMock();
        $em = $this->getMockBuilder(EntityManager ::class)
            ->disableOriginalConstructor()
            ->getMock();

        $getDns = new GetDns($requestStack, $em);

        $this->assertSame($requestStack, $getDns->getRequestStack());
        $this->assertSame($em,$getDns->getEm());
    }

    public function testGetDns()
    {
        $httpHost = 'http://www.test.com';
        $result = 'result';
        $request = $this->getMockBuilder(Request ::class)
            ->disableOriginalConstructor()
            ->getMock();
        $request->expects($this->once())
            ->method('getHttpHost')
            ->will($this->returnValue($httpHost));
        $requestStack = $this->getMockBuilder(RequestStack ::class)
            ->disableOriginalConstructor()
            ->getMock();
        $requestStack->expects($this->once())
            ->method('getCurrentRequest')
            ->will($this->returnValue($request));


        $dnsRepository = $this->getMockBuilder(DnsRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $dnsRepository->expects($this->once())
            ->method('getDnsByDomaineName')
            ->will($this->returnValue($result));


        $em = $this->getMockBuilder(EntityManager ::class)
            ->disableOriginalConstructor()
            ->getMock();
        $em->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($dnsRepository));

        $getDns = new GetDns($requestStack, $em);

        $this->assertSame($result, $getDns->getDns());
    }
}