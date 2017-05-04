<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 24/04/2017
 * Time: 17:57
 */

namespace Tests\Alcyon\CoreBundle\Repository;


use Alcyon\CoreBundle\Entity\Media;
use Tests\Alcyon\FixtureAwareTestCase;

class MediaRepositoryTest extends FixtureAwareTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Doctrine\Common\DataFixtures\AbstractFixture;
     */
    private $abstractFixture;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();
        /**
         * @var EntityManager
         */
        $this->em = self::$kernel->getContainer()->get('doctrine')->getManager();
        $this->executeFixtures();
    }

    public function testFindByCatalogueWithParents()
    {
        $repository = $this->em->getRepository('AlcyonCoreBundle:Media');

        $this->assertSame('SELECT m FROM '.Media::class.' m LEFT JOIN m.periodes p WHERE m.url like :url AND (p.start <= :start  OR p.start IS NULL) AND (p.end <= :end OR p.end IS NULL)',
            $repository->qbFindMediaUrl('url')->getDQL());

        // TODO : Améliorer ce test via des datafixture de test
        $this->assertCount(0, $repository->findMediaByUrl('url'));
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }

}