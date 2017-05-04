<?php
namespace Tests\Alcyon\CoreBundle\Repository;
use Alcyon\CoreBundle\Entity\Categorie;
use Alcyon\CoreBundle\Repository\Repository;
use Doctrine\ORM\EntityManager;
use Tests\Alcyon\FixtureAwareTestCase;
use Tests\Resources\DataFixtures\LoadCatalogue;
use Tests\Resources\DataFixtures\LoadCategorie;

class CategorieRepositoryTest extends FixtureAwareTestCase
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
        $this->addFixture($this->abstractFixture = new LoadCatalogue());
        $this->addFixture(new LoadCategorie());
        $this->executeFixtures();
    }

    public function testInstanceOfRepository()
    {
        $repository = $this->em->getRepository('AlcyonCoreBundle:Categorie');

        $this->assertInstanceOf(Repository::class, $repository);
    }

    public function testFindAll()
    {
        $repository = $this->em->getRepository('AlcyonCoreBundle:Categorie');

        $this->assertSame('SELECT u, p, c FROM '.Categorie::class.' u LEFT JOIN u.parents p LEFT JOIN u.childs c',
            $repository->qbFindAll()->getDQL());

        // count all categories
        $this->assertSame(6, count($repository->findAll()));
    }

    public function testFindByCatalogueWithParents()
    {
        $repository = $this->em->getRepository('AlcyonCoreBundle:Categorie');
        $catalogue = $this->abstractFixture->getReference('catalogue1');

        $this->assertSame('SELECT c, p FROM '.Categorie::class.' c LEFT JOIN c.parents p INNER JOIN c.catalogue ca WITH ca.id = :idCatalogue ORDER BY c.ordre ASC',
            $repository->qbFindByCatalogueWithParents($catalogue)->getDQL());

        // count categories by catalogue
        $this->assertSame(3, count($repository->findByCatalogueWithParents($catalogue)));
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
