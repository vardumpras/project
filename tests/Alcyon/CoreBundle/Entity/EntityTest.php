<?php

namespace Tests\Alcyon\CoreBundle\Entity;

use Alcyon\CoreBundle\Entity\Entity as BaseEntity;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    /**
     * @dataProvider dataForTestGetterSetterProvider
     */
    public function testGetterSetterMethod($data)
    {
        $stub = $this->getMockForAbstractClass(BaseEntity::class);

        $stub->setId($data);
        $this->assertSame($data, $stub->getId());
    }

    public function dataForTestGetterSetterProvider()
    {
        return [
            [null],
            [1],
            ['test']
        ];
    }

}