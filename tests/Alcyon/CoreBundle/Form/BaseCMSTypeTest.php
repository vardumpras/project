<?php

namespace Tests\Alcyon\CoreBundle\Form;

use Alcyon\CoreBundle\Component\ListHelper\Util\StringUtil;
use Alcyon\CoreBundle\Form\BaseCMSType;
use Alcyon\CoreBundle\Form\Form;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\PreloadedExtension;

class BaseCMSTypeTest extends TypeTestCase
{
    private $baseCmsType;

    /**
     * @dataProvider dataForTestSubmitValidDataProvider
     */
    public function testSubmitValidData($formData)
    {
        $form = $this->factory->create(get_class($this->baseCmsType));

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        // $object = TestObject::fromArray($formData);
        //$this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    public function dataForTestSubmitValidDataProvider()
    {
        return [
            [
                'data' => [
                    'title' => 'test',
                    'url' => 'test d\'url',
                    'content' => 'test de contenu',
                    'shortContent' => 'test de short contenu',
                    'ordre' =>      'test d\'ordre',
                    'defaultImage' => 'null',
                ]
            ]
        ];
    }
    public function testExtendsClass()
    {
        $this->assertInstanceOf(Form::class, $this->baseCmsType);
    }

    protected function getExtensions()
    {
        $this->baseCmsType = $this->getMockForAbstractClass(BaseCMSType::class);

        return [
            new PreloadedExtension ( [$this->baseCmsType],
                []
            ),
        ];
    }
}