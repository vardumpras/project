<?php

namespace Tests\Alcyon\CoreBundle\Entity;

use Alcyon\CoreBundle\Entity\Media;
use Alcyon\CoreBundle\Entity\MappedSuperclass;
use Alcyon\CoreBundle\Entity\Catalogue;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class MediaTest extends TestCase
{
    public function testConstructor()
    {
        $media = new Media();

        $this->assertSame(null ,$media->getFile());
        $media->setFile('file');
        $this->assertSame('file',$media->getFile());

        $this->assertSame(null ,$media->getAlt());
        $media->setAlt('alt');
        $this->assertSame('alt',$media->getAlt());

        $this->assertSame(null ,$media->getFolder());
        $media->setFolder('folder');
        $this->assertSame('folder',$media->getFolder());
    }


    public function testExtendsClass()
    {
        $media = new Media();

        $this->assertInstanceOf(MappedSuperclass\BaseCMS::class, $media);
        $this->assertInstanceOf(MappedSuperclass\AuthorInterface::class, $media);
        $this->assertInstanceOf(MappedSuperclass\DnssInterface::class, $media);
        $this->assertInstanceOf(MappedSuperclass\PeriodesInterface::class, $media);
        $this->assertInstanceOf(MappedSuperclass\SoftDeleteInterface::class, $media);
    }
}