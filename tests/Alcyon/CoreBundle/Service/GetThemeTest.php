<?php

namespace Tests\Alcyon\CoreBundle\Service;

use Alcyon\CoreBundle\Entity\Dns;
use Alcyon\CoreBundle\Repository\ThemeRepository;
use Alcyon\CoreBundle\Service\GetTheme;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class GetThemeTest extends TestCase
{

    private $em;
    /**
     * @var GetTheme
     */
    private $getTheme;

    public function setUp()
    {
        $this->em = $this->getMockBuilder(EntityManager ::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->getTheme = new GetTheme($this->em);
    }

    public function testConstruct()
    {

        $this->assertSame($this->em, $this->getTheme->getEm());
    }

    public function testGetThemeWithoutDns()
    {
        $theme = 'theme';

        $repository = $this->getMockBuilder(ThemeRepository ::class)
            ->disableOriginalConstructor()
            ->getMock();
        $repository->expects($this->once())
            ->method('getDefault')
            ->will($this->returnValue($theme));

        $this->em->expects($this->once())
            ->method('getRepository')
            ->with($this->equalTo('AlcyonCoreBundle:Theme'))
            ->will($this->returnValue($repository));

        $this->assertSame($theme, $this->getTheme->getTheme());
    }

    public function testGetThemeWithDns()
    {
        $theme = 'theme';
        $dns = $this->getMockBuilder(Dns ::class)
            ->disableOriginalConstructor()
            ->getMock();
        $dns->expects($this->once())
            ->method('getTheme')
            ->will($this->returnValue($theme));

        $this->assertSame($theme, $this->getTheme->getTheme($dns));
    }

}