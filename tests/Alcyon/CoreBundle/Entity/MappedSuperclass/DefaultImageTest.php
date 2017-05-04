<?php

namespace Tests\Alcyon\CoreBundle\Entity\MappedSuperclass;

use Alcyon\CoreBundle\Entity\MappedSuperclass\DefaultImage;
use Alcyon\CoreBundle\Entity\Media;
use PHPUnit\Framework\TestCase;

class DefaultImageTest extends TestCase
{
    public function testGetterSetter()
    {
        $defaultImage = $this->getMockForTrait(DefaultImage::class);

        $media = null;
        $defaultImage->setDefaultImage($media);
        $this->assertSame($media, $defaultImage->getDefaultImage());

        $media = $this->getMockBuilder(Media::class)
            ->disableOriginalConstructor()
            ->getMock();
        $defaultImage->setDefaultImage($media);
        $this->assertSame($media, $defaultImage->getDefaultImage());
    }
}