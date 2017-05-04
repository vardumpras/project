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
use Alcyon\CoreBundle\Component\ListHelper\Exception\UnexpectedTypeException;

class ArrayData extends AbstractData
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var ArrayIterator
     */
    private $iterator;

    /**
     * {@inheritdoc}
     */    
    protected function setParametersChange()
    {
        $this->iterator = null;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        if(null == $this->iterator) {
            $data = clone $this->data;
            
            $optionComparaison = [];
            $optionOrderBy = [];
            $optionPaginator = [];
            
            // Get Options Filters
            foreach($this->getFilters() as $filter) {
                foreach($filter->getDataFilters() as $dataFilter) {
                    $options =  $dataFilter->getOptions();
                    if(get_class($dataFilter) == DataFilter\ComparisonDataFilter::class) {
                        $optionComparaison[] = $options;
                    } else if(get_class($dataFilter) == DataFilter\OrderByDataFilter::class) {
                        $optionOrderBy[] = $options;
                    } else if(get_class($dataFilter) == DataFilter\PaginatorDataFilter::class) {
                        $optionPaginator[] = $options;
                    } else {
                        throw new InvalidArgumentException(sprintf('The class "%s" only support "%s", "%s" and "%s", "%s" given', 
                                                        get_class($this),
                                                        DataFilter\ComparisonDataFilter::class,
                                                        DataFilter\OrderByDataFilter::class,
                                                        DataFilter\PaginatorDataFilter::class),
                                                        get_class($dataFilter));
                    }
                }
            }
            
            // Use options filters
            foreach($optionComparaison as $options) {
            }
            
            foreach($optionOrderBy as $options) {
            }
            
            foreach($optionPaginator as $options) {
            }
            
            $this->iterator = new \ArrayIterator($data);
        }
        
        return $this->iterator;
    }

    
    /**
     * {@inheritdoc}
     */        
    public function setData($data)
    {
        if(null === $data)
            $data = [];
            
        if(!is_array($data) && !is_object($data) && (is_object($data) && !$data instanceof \Iterator )) {
            throw new UnexpectedTypeException('$data must by a type of array or \Iterator');
        }
        
    
        $this->data = $data;
        $this->setParametersChange();
        
        return $this;
    }
}