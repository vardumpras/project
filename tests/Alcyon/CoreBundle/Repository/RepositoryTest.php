<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 20/04/2017
 * Time: 14:16
 */

namespace Tests\Alcyon\CoreBundle\Repository;

use Alcyon\CoreBundle\Repository\Repository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use Tests\Alcyon\FixtureAwareTestCase;

class RepositoryTest extends FixtureAwareTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

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
    }

    public function testFunctionJoinParents()
    {
        $this->callFunctionWithParameters('join', 'table', 'parents', 'aliasparents');
        $this->callFunctionWithoutParameters('join', 'u', 'parents', 'p');
    }

    public function testFunctionLeftJoinParents()
    {
        $this->callFunctionWithParameters('leftJoin', 'table', 'parents', 'aliasparents');
        $this->callFunctionWithoutParameters('leftJoin', 'u', 'parents', 'p');
    }

    public function testFunctionJoinChilds()
    {
        $this->callFunctionWithParameters('join', 'table', 'childs', 'aliaschilds');
        $this->callFunctionWithoutParameters('join', 'u', 'childs', 'c');
    }

    public function testFunctionLeftJoinChils()
    {
        $this->callFunctionWithParameters('leftJoin', 'table', 'childs', 'aliaschilds');
        $this->callFunctionWithoutParameters('leftJoin', 'u', 'childs', 'c');
    }

    public function testFunctionJoinParentsAndChilds()
    {
        $repository = new Repository($this->em, new ClassMetadata('AlcyonCoreBundle:Repository'));
        $queryBuilder = $repository->joinParentsAndChilds(null , 'u', 'p', 'c');

        $this->assertSame('SELECT u, p, c FROM AlcyonCoreBundle:Repository u INNER JOIN u.parents p INNER JOIN u.childs c',
            $queryBuilder->getDQL());
    }

    public function testFunctionLeftJoinParentsAndChilds()
    {
        $repository = new Repository($this->em, new ClassMetadata('AlcyonCoreBundle:Repository'));
        $queryBuilder = $repository->leftJoinParentsAndChilds(null , 'u', 'p', 'c');

        $this->assertSame('SELECT u, p, c FROM AlcyonCoreBundle:Repository u LEFT JOIN u.parents p LEFT JOIN u.childs c',
            $queryBuilder->getDQL());
    }

    private function callFunctionWithParameters($type, $tableAlias, $field, $alias)
    {
        $repository = new Repository($this->em, new ClassMetadata('AlcyonCoreBundle:Repository'));
        $queryBuilder = $repository->{$type.ucfirst($field)}(null , $tableAlias, $alias);

        $type = $type =='join' ? 'INNER JOIN' : 'LEFT JOIN';
        $this->assertSame("SELECT $tableAlias, $alias FROM AlcyonCoreBundle:Repository $tableAlias $type $tableAlias.$field $alias",
            $queryBuilder->getDQL());
    }
    
    private function callFunctionWithoutParameters($type, $tableAlias, $field, $alias)
    {
        $repository = new Repository($this->em, new ClassMetadata('AlcyonCoreBundle:Repository'));
        $queryBuilder = $repository->{$type.ucfirst($field)}();

        $type = $type =='join' ? 'INNER JOIN' : 'LEFT JOIN';
        $this->assertSame("SELECT $tableAlias, $alias FROM AlcyonCoreBundle:Repository $tableAlias $type $tableAlias.$field $alias",
            $queryBuilder->getDQL());
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