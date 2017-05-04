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

use Alcyon\CoreBundle\Component\ListHelper\Element\ColumnElement;

/**
 * The builder of the ListHelper component.
 */
interface BuilderInterface
{
    /**
     * Adds a new element to this group. A element must have a unique name within
     * the group. Otherwise the existing element is overwritten.
     *
     * @param string   	$name
     * @param string 	$element
     * @param array     $options
     *
     * @return BuilderInterface The object
     */
    public function add($name, $element = ColumnElement::class, array $options = []);
    
    /**
     * Returns a List.
     *
     * @return ListHelper The list created
     */
    public function createList();  
}
