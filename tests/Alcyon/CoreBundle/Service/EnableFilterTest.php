<?php

namespace Tests\Alcyon\CoreBundle\Service;

use Alcyon\CoreBundle\Service\EnabledFilter;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetaData;
use PHPUnit\Framework\TestCase;

class EnableFilterTest extends TestCase
{
    private $enabled = null;

    public function setUp()
    {
        $emInterface = $this->createMock(EntityManagerInterface::class);
        $this->enabled = new EnabledFilter($emInterface);
    }

    public function testGetterSetter()
    {
        $dateTime = $this->enabled->getDate();
        $this->assertSame(get_class($dateTime), \DateTime::class );

        $dateTime = new \DateTime();
        $this->enabled->setDate($dateTime);
        $this->assertSame($dateTime, $this->enabled->getDate());

        $this->expectException(\TypeError::class);
        $this->enabled->setDate(null);
    }

    public function testNoAddSql()
    {
        $medaData = $this->getMockBuilder(ClassMetadata::class)
            ->disableOriginalConstructor()
            ->getMock();

        $medaData->expects($this->once())
            ->method('hasField')
            ->with($this->equalTo('enabledAt'))
            ->will($this->returnValue(false));

        $this->assertSame('', $this->enabled->addFilterConstraint($medaData, ''));
    }

    public function testAddSql()
    {
        $dateTime = new \DateTime();
        $date = $dateTime->format("Y-m-d H:i:s");
        $this->enabled->setDate($dateTime);

        $medaData = $this->getMockBuilder(ClassMetadata::class)
            ->disableOriginalConstructor()
            ->getMock();

        $medaData->expects($this->once())
            ->method('hasField')
            ->with($this->equalTo('enabledAt'))
            ->will($this->returnValue(true));

        $alias = 'alias';
        $this->assertSame($alias.".enabledAt <= '".$date."' OR ".$alias.".enabledAt IS NULL",
            $this->enabled->addFilterConstraint($medaData, $alias));

    }
}