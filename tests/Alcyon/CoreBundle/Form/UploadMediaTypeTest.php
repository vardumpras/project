<?php

namespace Tests\Alcyon\CoreBundle\Form;

use Alcyon\CoreBundle\Form\MediaType;
use Alcyon\CoreBundle\Form\UploadMediaType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tests\Resources\Tools;

class UploadMediaTypeTest extends TypeTestCase
{

    public function testExtendClass()
    {
        $this->assertTrue(is_subclass_of(UploadMediaType::class, MediaType::class));
    }

    public function testSubmitValidData()
    {
        $photo = new UploadedFile(
            Tools::folderImagePath . 'test.jpg',
            'test.jpg',
            'image/jpeg',
            123
        );
        $formData = ['file' => $photo,
            'url' => 'image-test.jpg'];


        $form = $this->factory->create(UploadMediaType::class);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $media = $form->getData();

        $this->assertSame($formData['url'], $media->getUrl());
        $this->assertSame($photo, $media->getFile());

    }
}