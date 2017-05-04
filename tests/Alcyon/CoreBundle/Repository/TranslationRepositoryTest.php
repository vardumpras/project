<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 24/04/2017
 * Time: 17:25
 */

namespace Tests\Alcyon\CoreBundle\Repository;

use Tests\Alcyon\FixtureAwareTestCase;
use Tests\Resources\DataFixtures\LoadLanguageAndTranslation;

class TranslationRepositoryTest extends FixtureAwareTestCase
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
        $this->addFixture($this->abstractFixture = new LoadLanguageAndTranslation());
        $this->executeFixtures();
    }

    public function testGetTranslations()
    {
        $repository = $this->em->getRepository('AlcyonCoreBundle:Translation');
        $language = $this->abstractFixture->getReference('language')->getLanguage();

        $qb = $repository->qbGetTranslations($language);
        $this->assertSame('SELECT t FROM Alcyon\CoreBundle\Entity\Translation t INNER JOIN t.language l WHERE l.language like :language', $qb->getDQL());
        $this->assertSame($language, $qb->getParameter('language')->getValue());

        $this->assertCount(3, $repository->getTranslations($language));
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