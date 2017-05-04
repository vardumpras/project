<?php

namespace Alcyon\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class Repository extends EntityRepository
{
    /**
     * Join and load parents to QueryBuilder
     * Creates a new QueryBuilder instance if not exist
     *
     * @param QueryBuilder          $qb
     * @param string $tableAlias    The table alias
     * @param string $alias         The parents alias
     *
     * @return QueryBuilder
     */
	public function joinParents(QueryBuilder $qb= null, $tableAlias = 'u', $alias = 'p')
	{

		if(null == $qb)
			$qb = $this->createQueryBuilder($tableAlias);

		$qb->join($tableAlias .'.parents', $alias)->addSelect($alias);

		return $qb;
	}

    /**
     * Join and load childs to QueryBuilder
     * Creates a new QueryBuilder instance if not exist
     *
     * @param QueryBuilder          $qb
     * @param string $tableAlias    The table alias
     * @param string $alias         The childs alias
     *
     * @return QueryBuilder
     */
    public function joinChilds($qb= null, $tableAlias = 'u', $alias = 'c')
	{

		if(null == $qb)
			$qb = $this->createQueryBuilder($tableAlias);
		
		$qb->join($tableAlias .'.childs', $alias)->addSelect($alias);
				
		return $qb;
	}

    /**
     * Join and load parents and childs to QueryBuilder
     * Creates a new QueryBuilder instance if not exist
     *
     * @param QueryBuilder          $qb
     * @param string $tableAlias    The table alias
     * @param string $aliasParent   The parents alias
     * @param string $aliasChild The childs alias
     *
     * @return QueryBuilder
     */
    public function joinParentsAndChilds($qb= null, $tableAlias = 'u', $aliasParent = 'p', $aliasChild = 'c')
    {
        if(null == $qb)
            $qb = $this->createQueryBuilder($tableAlias);

        $qb = $this->joinParents($qb, $tableAlias, $aliasParent);
        $qb = $this->joinChilds($qb, $tableAlias, $aliasChild);

        return $qb;
    }

    /**
     * Left-Join and load parents to QueryBuilder
     * Creates a new QueryBuilder instance if not exist
     *
     * @param QueryBuilder          $qb
     * @param string $tableAlias    The table alias
     * @param string $alias         The parents alias
     *
     * @return QueryBuilder
     */
    public function leftJoinParents($qb= null, $tableAlias = 'u', $alias = 'p')
	{

		if(null == $qb)
			$qb = $this->createQueryBuilder($tableAlias);

		$qb->leftJoin($tableAlias . '.parents', $alias)->addSelect($alias);

		return $qb;
	}

    /**
     * Left-Join and load childs to QueryBuilder
     * Creates a new QueryBuilder instance if not exist
     *
     * @param QueryBuilder          $qb
     * @param string $tableAlias    The table alias
     * @param string $alias         The childs alias
     *
     * @return QueryBuilder
     */
    public function leftJoinChilds($qb= null, $tableAlias = 'u', $alias = 'c')
	{

		if(null == $qb)
			$qb = $this->createQueryBuilder($tableAlias);
		
		$qb->leftJoin($tableAlias . '.childs', $alias)->addSelect($alias);
				
		return $qb;
	}

    /**
     * Left-Join and load parents and childs to QueryBuilder
     * Creates a new QueryBuilder instance if not exist
     *
     * @param QueryBuilder          $qb
     * @param string $tableAlias    The table alias
     * @param string $aliasParent   The parents alias
     * @param string $aliasChild The childs alias
     *
     * @return QueryBuilder
     */
    public function leftJoinParentsAndChilds($qb= null, $tableAlias = 'u', $aliasParent = 'p', $aliasChild = 'c')
	{
		if(null == $qb)
			$qb = $this->createQueryBuilder($tableAlias);
            
		$qb = $this->leftJoinParents($qb, $tableAlias, $aliasParent);
		$qb = $this->leftJoinChilds($qb, $tableAlias, $aliasChild);

		return $qb;
	}
}