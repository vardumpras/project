<?php

namespace Tests\Alcyon\CoreBundle\Translation;

use Alcyon\CoreBundle\Entity\Translation;
use Alcyon\CoreBundle\Repository\TranslationRepository;
use Alcyon\CoreBundle\Translation\DbLoader;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\MessageCatalogue;

class DbLoaderTest extends TestCase
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var DbLoader
     */
    private $dbLoader;

    public function setUp()
    {
        $this->em = $this->createMock(EntityManagerInterface::class);

        $this->dbLoader = new DbLoader($this->em);
    }

    public function testConstructor()
    {
        $this->assertSame($this->em, $this->dbLoader->getEm());
    }

    public function testReturnMessageCatalogueClass()
    {
        $locale= 'fr';

        $this->em->expects($this->once())
            ->method('getRepository')
            ->with($this->equalTo('AlcyonCoreBundle:Translation'))
            ->will($this->returnValue($this->createRepository($locale, [])));

        $this->assertInstanceOf(MessageCatalogue::class, $this->dbLoader->load('ressource', $locale));
    }

    public function testWithTranslationResults()
    {
        $locale= 'fr';
        $datas = [];
        foreach (range(1,10) as $key) {
             $translation= $this->createMock(Translation::class);
             $translation->expects($this->once())
                ->method('getKeyTrans')
                ->with()
                ->will($this->returnValue($key));
             $translation->expects($this->once())
                ->method('getData')
                ->with()
                ->will($this->returnValue('Data'.$key));
            $datas[] = $translation;
        }

        $this->em->expects($this->once())
            ->method('getRepository')
            ->with($this->equalTo('AlcyonCoreBundle:Translation'))
            ->will($this->returnValue($this->createRepository($locale, $datas)));

        $domaine = 'domaine';
        $message = $this->dbLoader->load('ressource', $locale, $domaine);
        $this->assertCount(10, $message->all($domaine));
        foreach (range(1,10) as $key) {
            $this->assertSame('Data'.$key, $message->get($key, $domaine));
        }
    }

    private function createRepository($locale, $datas)
    {
        $repository = $this->getMockBuilder(TranslationRepository ::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repository->expects($this->once())
            ->method('getTranslations')
            ->with($this->equalTo($locale))
            ->will($this->returnValue($datas));

        return $repository;
    }
}