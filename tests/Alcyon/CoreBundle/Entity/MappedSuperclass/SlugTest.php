<?php

namespace Tests\Alcyon\CoreBundle\Entity\MappedSuperclass;

use Alcyon\CoreBundle\Entity\MappedSuperclass\Slug;
use PHPUnit\Framework\TestCase;

class SlugTest extends TestCase
{
    /**
     * @dataProvider dataForTestGetterSetterProvider
     */
    public function testGetterSetter($dataOriginal)
    {
        $slug = $this->getMockForAbstractClass(Slug::class);
        $this->assertSame(null, $slug->getSlug());

        $slug->setSlug($dataOriginal);
        $this->assertSame( $dataOriginal, $slug->getSlug());
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