<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 16/03/2017
 * Time: 15:23
 */

namespace Tests\Alcyon\CoreBundle\Entity\MappedSuperclass;

use Alcyon\CoreBundle\Entity\MappedSuperclass\Author;
use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase
{
    /**
     * @dataProvider dataForTestGetterSetterProvider
     */
    public function testGetterSetter($at, $by)
    {
        $author = $this->getMockForTrait(Author::class);

        $author->setUpdatedAt($at);
        $this->assertSame($at, $author->getUpdatedAt());

        $author->setUpdatedBy($by);
        $this->assertSame($by, $author->getUpdatedBy());
    }

    public function dataForTestGetterSetterProvider()
    {
        return [
            [null, null],
            [null, 'string'],
            [new \DateTime(), null],
            [new \DateTime(), 'string']
        ];
    }

    /**
     * @dataProvider dataForTestExceptionProvider
     */
    public function testUpdatedAtException($at)
    {
        $author = $this->getMockForTrait(Author::class);

        $this->expectException(\LogicException::class);
        $author->setUpdatedAt($at);
    }

    /**
     * @dataProvider dataForTestExceptionProvider
     */
    public function testUpdatedByException($at)
    {
        $author = $this->getMockForTrait(Author::class);

        $this->expectException(\LogicException::class);
        $author->setUpdatedBy($at);
    }

    public function dataForTestExceptionProvider()
    {
        return [
            [1],
            [1.1],
            [true],
            [new \stdClass()]
        ];
    }
}