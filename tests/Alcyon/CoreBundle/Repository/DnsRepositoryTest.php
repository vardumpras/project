<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 24/04/2017
 * Time: 18:01
 */

namespace Tests\Alcyon\CoreBundle\Repository;

use Tests\Alcyon\FixtureAwareTestCase;
use Tests\Resources\DataFixtures\LoadThemeAndDns;

class DnsRepositoryTest extends FixtureAwareTestCase
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
        $this->addFixture($this->abstractFixture = new LoadThemeAndDns());
        $this->executeFixtures();
    }

    public function testFindByCatalogueWithParents()
    {
        $repository = $this->em->getRepository('AlcyonCoreBundle:Dns');

        $this->assertSame('SELECT d, t FROM Alcyon\CoreBundle\Entity\Dns d INNER JOIN d.theme t WHERE d.dns like :dns',
            $repository->qbGetDnsWithTheme('dsn.test.com')->getDQL());
        // TODO ; Check DQL parameters
        $this->assertNull( $repository->getDnsByDomaineName('test.test.test'));

        $this->assertSame($this->abstractFixture->getReference('dns'), $repository->getDnsByDomaineName('dsn.test.com'));
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