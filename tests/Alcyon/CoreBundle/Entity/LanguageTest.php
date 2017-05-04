<?php

namespace Tests\Alcyon\CoreBundle\Entity;

use Alcyon\CoreBundle\Entity\Language;
use Alcyon\CoreBundle\Entity\MappedSuperclass;
use PHPUnit\Framework\TestCase;

class LanguageTest extends TestCase
{
    public function testGetterSetter()
    {
        $language = new Language();

        $this->assertSame(null, $language->getLanguage());

        $language->setLanguage('fr');
        $this->assertSame('fr', $language->getLanguage());
    }

    /**
     * @dataProvider dataForTestLogicExceptionProvider
     */
    public function testLogicException($data)
    {
        $language = new Language();

        $this->expectException(\LogicException::class);
        $language->setLanguage($data);
    }

    public function dataForTestLogicExceptionProvider()
    {
        return [
            [null],
            [''],
            [0],
            ['abc'],
            [1],
            [[]],
            [['test']],
            [new \stdClass()],
        ];
    }

    public function testExtendsClass()
    {
        $language = new Language();

        $this->assertInstanceOf(MappedSuperclass\BaseCMS::class, $language);
        $this->assertInstanceOf(MappedSuperclass\AuthorInterface::class, $language);
        $this->assertInstanceOf(MappedSuperclass\SoftDeleteInterface::class, $language);
    }
}