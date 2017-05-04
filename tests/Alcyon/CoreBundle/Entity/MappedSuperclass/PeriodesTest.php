<?php

namespace Tests\Alcyon\CoreBundle\Entity\MappedSuperclass;

use Alcyon\CoreBundle\Entity\MappedSuperclass\Periodes;
use Alcyon\CoreBundle\Entity\Periode;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class PeriodesTest extends TestCase
{
    public function testInitDnssAutoCall()
    {
        $periodes = $this->getMockForTrait(Periodes::class);
        $this->assertInstanceOf(Collection::class, $periodes->getPeriodes());
        $this->assertCount(0, $periodes->getPeriodes());

        $periode = $this->getMockBuilder(Periode::class)
            ->disableOriginalConstructor()
            ->getMock();
        $periodes = $this->getMockForTrait(Periodes::class);
        $this->assertSame($periodes, $periodes->addPeriode($periode));
        $this->assertCount(1, $periodes->getPeriodes());

        $periodes = $this->getMockForTrait(Periodes::class);
        $this->assertSame($periodes, $periodes->removePeriode($periode));
        $this->assertCount(0, $periodes->getPeriodes());
    }

    public function testAddAndRemoveMedia()
    {
        $periodes = $this->getMockForTrait(Periodes::class);

        $periode = $this->getMockBuilder(Periode::class)
            ->disableOriginalConstructor()
            ->getMock();

        $periodes->addPeriode($periode);
        $this->assertCount(1, $periodes->getPeriodes());
        // Double add, test
        $periodes->addPeriode($periode);
        $this->assertCount(1, $periodes->getPeriodes());

        //Remove
        $periodeNew = $this->getMockBuilder(Periode::class)
            ->disableOriginalConstructor()
            ->getMock();
        $periodes->removePeriode($periodeNew);
        $this->assertCount(1, $periodes->getPeriodes());
        foreach ($periodes->getPeriodes() as $testDns)
            $this->assertSame($periode, $testDns);

        $periodes->addPeriode($periodeNew);
        $this->assertCount(2, $periodes->getPeriodes());

        $periodes->removePeriode($periode);
        $this->assertCount(1, $periodes->getPeriodes());
        foreach ($periodes->getPeriodes() as $testDns)
            $this->assertSame($periodeNew, $testDns);
    }
}