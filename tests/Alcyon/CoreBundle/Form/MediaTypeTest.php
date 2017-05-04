<?php

namespace Tests\Alcyon\CoreBundle\Form;

use Alcyon\CoreBundle\Entity\Media;
use Alcyon\CoreBundle\Form\Form;
use Alcyon\CoreBundle\Form\MediaType;
use Symfony\Component\Form\Test\TypeTestCase;

class MediaTypeTest extends TypeTestCase
{
    private $formData = [ 'url' => '', 'title' => '', 'alt' => ''];

    public function testExtendClass()
    {
        $this->assertTrue(is_subclass_of(MediaType::class, Form::class));
    }

    public function testSubmitValidData()
    {
        $media = new Media();

        $form = $this->factory->create(MediaType::class, $media);

        $this->assertEquals($media, $form->getData());
        // submit the data to the form directly
        $form->submit($this->formData);

        $this->assertTrue($form->isSynchronized());

    }
}