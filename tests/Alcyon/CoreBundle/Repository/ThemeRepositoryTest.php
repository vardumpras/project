<?php

namespace Tests\Alcyon\CoreBundle\Repository;

use Tests\Alcyon\FixtureAwareTestCase;
use Tests\Resources\DataFixtures\LoadTheme;
use Tests\Resources\DataFixtures\LoadThemeAndDns;

class ThemeRepositoryTest extends FixtureAwareTestCase
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

    public function testFunctionGetDefault()
    {
        // Load fixture
        $defaultTheme = $this->abstractFixture->getReference('default theme');
        $this->assertNotNull($defaultTheme);

        // Verify getDefault theme
        $repository = $this->em->getRepository('AlcyonCoreBundle:Theme');
        $this->assertSame($defaultTheme, $repository->getDefault());
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