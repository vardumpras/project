<?php

/*
 * This file is part of the AlcyonCoreBundle package.
 *
 * (c) David DE SOUSA <d.desousa@alcyon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alcyon\CoreBundle\Component\ListHelper\Data;

use Alcyon\CoreBundle\Component\ListHelper\Data\Filter as DataFilter;
use Alcyon\CoreBundle\Component\ListHelper\Exception\InvalidArgumentException;
use Alcyon\CoreBundle\Component\ListHelper\FilterInterface;
use Doctrine\ORM\EntityRepository as Repository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class DoctrineData extends AbstractData
{
    /**
     * @var Query
     */
    private $QueryBuilder;
    
    /**
     * @var Paginator
     */
    private $paginator;
    
    /**
     * {@inheritdoc}
     */    
    protected function setParametersChange()
    {
        $this->paginator = null;
    }
    
    /**
     * {@inheritdoc}
     */        
    public function setData($data)
    {
        if ($data instanceof Repository) {  
            $data = $data->createQueryBuilder('a');
        }
        
        
        if(!is_object($data) || !$data instanceof QueryBuilder) {
            throw new InvalidArgumentException(sprintf('Could not load "%s"', $data));
        }
        
        $this->query = $data;
        $this->setParametersChange();
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->getPaginator()->count();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return $this->getPaginator()->getIterator();
    }

    /**
     * Return a Paginator
     */
    private function getPaginator()
    {
        if(null == $this->paginator) {
        
            // Clone to preserve original query
            $query = clone $this->query;
            
            // Use Filters
            foreach($this->getFilters() as $filter) {
                foreach($filter->getDataFilters() as $dataFilter) {

                    if($dataFilter instanceof DataFilter\ComparisonDataFilter) {
                        $value = $dataFilter->getValue();

                        if($value) {

                            $condition = $dataFilter->getCondition();
                            $field = $dataFilter->getField();
                            
                            $expression = $query->expr();
                            $alias = ($query->getRootAliases())[0];

                            $query->andWhere($expression->$condition($alias . '.' . $field, ':list_helper_data_filter_' . $field))
                                  ->setParameter('list_helper_data_filter_' . $field, $value);
                        }
                            
                    } else if($dataFilter instanceof  DataFilter\OrderDataFilter) {
                        $field = $dataFilter->getOrderBy();
                        $way = $dataFilter->getOrderWay();
                        $alias = ($query->getRootAliases())[0];
                        if($field && $way)
                            $query->addOrderBy($alias . '.' . $field, $way);
                        
                    } else if($dataFilter instanceof  DataFilter\PaginatorDataFilter) {
                        // Set item per page
                        $currentpage = $dataFilter->getPage();
                        $itemperpage = $dataFilter->getItemperpage();
                        
                        if($itemperpage>0)
                            $query  ->setFirstResult(($currentpage -1) * $itemperpage )
                                    ->setMaxResults($itemperpage);
                    } else {
                        throw new InvalidArgumentException(sprintf('The class "%s" only support "%s", "%s" and "%s", "'.get_class($dataFilter).'" given', 
                                                        get_class($this),
                                                        DataFilter\ComparisonDataFilter::class,
                                                        DataFilter\OrderByDataFilter::class,
                                                        DataFilter\PaginatorDataFilter::class));
                    }
                }
            }
    

            // Generate Paginator
            $this->paginator = new Paginator($query->getQuery());
        }
        
        return $this->paginator;
    }
}