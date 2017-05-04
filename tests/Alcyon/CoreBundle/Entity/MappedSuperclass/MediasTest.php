<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 17/03/2017
 * Time: 11:58
 */

namespace Tests\Alcyon\CoreBundle\Entity\MappedSuperclass;

use Alcyon\CoreBundle\Entity\MappedSuperclass\Medias;
use Alcyon\CoreBundle\Entity\Media;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class MediaTest  extends TestCase
{
    public function testInitMediasAutoCall()
    {
        $medias = $this->getMockForTrait(Medias::class);
        $this->assertInstanceOf(Collection::class, $medias->getMedias());
        $this->assertCount(0, $medias->getMedias());

        $media = $this->getMockBuilder(Media::class)
            ->disableOriginalConstructor()
            ->getMock();
        $medias = $this->getMockForTrait(Medias::class);
        $this->assertSame($medias, $medias->addMedias($media));
        $this->assertCount(1, $medias->getMedias());

        $medias = $this->getMockForTrait(Medias::class);
        $this->assertSame($medias, $medias->removeMedias($media));
        $this->assertCount(0, $medias->getMedias());
    }

    public function testAddAndRemoveMedia()
    {
        $medias = $this->getMockForTrait(Medias::class);

        $media = $this->getMockBuilder(Media::class)
            ->disableOriginalConstructor()
            ->getMock();

        $medias->addMedias($media);
        $this->assertCount(1, $medias->getMedias());
        // Double add, test
        $medias->addMedias($media);
        $this->assertCount(1, $medias->getMedias());

        //Remove
        $mediaNew = $this->getMockBuilder(Media::class)
            ->disableOriginalConstructor()
            ->getMock();
        $medias->removeMedias($mediaNew);
        $this->assertCount(1, $medias->getMedias());
        foreach ($medias->getMedias() as $testDns)
            $this->assertSame($media, $testDns);

        $medias->addMedias($mediaNew);
        $this->assertCount(2, $medias->getMedias());

        $medias->removeMedias($media);
        $this->assertCount(1, $medias->getMedias());
        foreach ($medias->getMedias() as $testMedia)
            $this->assertSame($mediaNew, $testMedia);
    }
}