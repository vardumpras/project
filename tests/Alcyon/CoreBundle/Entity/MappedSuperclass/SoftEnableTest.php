<?php

namespace Tests\Alcyon\CoreBundle\Entity\MappedSuperclass;

use Alcyon\CoreBundle\Entity\MappedSuperclass\SoftEnable;
use PHPUnit\Framework\TestCase;

class SoftEnableTest  extends TestCase
{
    public function testGetterSetter()
    {
        $softEnable = $this->getMockForTrait(SoftEnable::class);
        $this->assertSame(null, $softEnable->getEnableAt());

        $dateTime = new \DateTime();
        $softEnable->setEnableAt($dateTime);
        $this->assertSame($dateTime, $softEnable->getEnableAt());
    }
}