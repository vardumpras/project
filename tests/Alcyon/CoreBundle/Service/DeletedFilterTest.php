<?php

namespace Tests\Alcyon\CoreBundle\Service;

use Alcyon\CoreBundle\Service\DeletedFilter;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetaData;
use PHPUnit\Framework\TestCase;

class DeletedFilterTest extends TestCase
{
    private $deleted = null;

    public function setUp()
    {
        $emInterface = $this->createMock(EntityManagerInterface::class);
        $this->deleted = new DeletedFilter($emInterface);
    }

    public function testGetterSetter()
    {
        $dateTime = $this->deleted->getDate();
        $this->assertSame(get_class($dateTime), \DateTime::class );

        $dateTime = new \DateTime();
        $this->deleted->setDate($dateTime);
        $this->assertSame($dateTime, $this->deleted->getDate());

        $this->expectException(\TypeError::class);
        $this->deleted->setDate(null);
    }

    public function testNoAddSql()
    {

        $medaData = $this->getMockBuilder(ClassMetadata::class)
            ->disableOriginalConstructor()
            ->getMock();

        $medaData->expects($this->once())
            ->method('hasField')
            ->with($this->equalTo('deletedAt'))
            ->will($this->returnValue(false));

        $this->assertSame('', $this->deleted->addFilterConstraint($medaData, ''));
    }

    public function testAddSql()
    {
        $dateTime = new \DateTime();
        $date = $dateTime->format("Y-m-d H:i:s");
        $this->deleted->setDate($dateTime);

        $medaData = $this->getMockBuilder(ClassMetadata::class)
            ->disableOriginalConstructor()
            ->getMock();

        $medaData->expects($this->once())
            ->method('hasField')
            ->with($this->equalTo('deletedAt'))
            ->will($this->returnValue(true));

        $alias = 'alias';
        $this->assertSame($alias.".deletedAt > '".$date."' OR ".$alias.".deletedAt IS NULL",
                            $this->deleted->addFilterConstraint($medaData, $alias));
    }
}