<?php

namespace Tests\Alcyon\CoreBundle\Entity\MappedSuperclass;

use Alcyon\CoreBundle\Entity\MappedSuperclass\SoftDelete;
use PHPUnit\Framework\TestCase;

class SoftDeleteTest  extends TestCase
{
    public function testGetterSetter()
    {
        $softDelete = $this->getMockForTrait(SoftDelete::class);
        $this->assertSame(null, $softDelete->getDeletedAt());
        $this->assertSame(null, $softDelete->getDeletedBy());

        $dateTime = new \DateTime();
        $softDelete->setDeletedAt($dateTime);
        $softDelete->setDeletedBy('test');
        $this->assertSame($dateTime, $softDelete->getDeletedAt());
        $this->assertSame('test', $softDelete->getDeletedBy());
    }
}