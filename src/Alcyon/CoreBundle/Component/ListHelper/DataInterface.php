<?php

/*
 * This file is part of the AlcyonCoreBundle package.
 *
 * (c) David DE SOUSA <d.desousa@alcyon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Alcyon\CoreBundle\Component\ListHelper;

use Symfony\Component\HttpFoundation\Request;

/**
 * The central data interface of the ListHelper component implements Coutable and IteratorAggregate
 */
interface DataInterface extends \Countable, \IteratorAggregate
{
     /**
     * Set the data for this List data
     *
     * @param mixed   	                    $data       the name of this filter
     *
     * @return ListHelperDataInterface      the List Helper data
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\UnexpectedTypeException if any given data is not applicable to the given Liste data
     */          
    public function setData($data);   
    
    /**
     * Add a filter as a child for filtering data
     *
     * @param string   	                    $name       the name of this filter
     * @param FilterInterface   	$filter     the filter
     *
     * @return DataInterface the List Helper data     
     */          
    public function addFilter($name, FilterInterface $filter);    
    
    /**
     * Get all filters 
     *
     * @return FilterInterface[]  array of filter
     */          
    public function getFilters();
    
    /**
     * Get iterator for this data using filter
     *
     * @return Iterator  iterator for this data
     *
     * @throws Exception\InvalidArgumentException if the filter is not supported by this data    
     */
    public function getIterator();
}