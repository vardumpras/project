<?php

namespace Tests\Alcyon\CoreBundle\Entity\MappedSuperclass;

use Alcyon\CoreBundle\Entity\MappedSuperclass\Ordre;
use PHPUnit\Framework\TestCase;

class OrdreTest  extends TestCase
{
    /**
     * @dataProvider dataForTestGetterSetterProvider
     */
    public function testGetterSetter($dataOriginal)
    {
        $ordre = $this->getMockForTrait(Ordre::class);
        $this->assertSame(0, $ordre->getOrdre());

        $ordre->setOrdre($dataOriginal);
        $this->assertSame((int) $dataOriginal, $ordre->getOrdre());
    }

    public function dataForTestGetterSetterProvider()
    {
        return [
            [0],
            [1],
            [10.214],
            [null],
            ['testy']
        ];
    }
}