<?php

namespace Tests\Alcyon\CoreBundle\Entity;

use Alcyon\CoreBundle\Entity\Language;
use Alcyon\CoreBundle\Entity\Entity as BaseEntity;
use Alcyon\CoreBundle\Entity\Translation;
use PHPUnit\Framework\TestCase;

class TranslationTest extends TestCase
{
    public function testGetterSetter()
    {
        $tranlation = new Translation();

        $language = $this->getMockBuilder(Language::class)
            ->disableOriginalConstructor()
            ->getMock();

        $tranlation->setLanguage($language);
        $this->assertSame($language, $tranlation->getLanguage());

        $tranlation->setKeyTrans('set keyTrans');
        $this->assertSame('set keyTrans', $tranlation->getKeyTrans());

        $tranlation->setData('set Data');
        $this->assertSame('set Data', $tranlation->getData());
    }

    public function testExtendsClass()
    {
        $language = new Translation();

        $this->assertInstanceOf(BaseEntity::class, $language);
    }
}