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

/**
 * The central factory of the ListHelper component.
 */
interface FactoryInterface
{
	/**
     * Returns a ListHelper.
     *
     * @param string $element The element of the list
     * @param mixed  $data    The initial data
     * @param array  $options The options
     *
     * @return ListHelper The list created
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException if any given option is not applicable to the given element
     */
    public function create($element = 'Alcyon\CoreBundle\Component\ListHelper\Element\ListElement', $data = null, array $options = array());
    
	/**
     * Returns a list builder.
     *
     * @param string $element The element of the list
     * @param mixed  $data    The initial data
     * @param array  $options The options
     *
     * @return ElementInterface The list builder
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException if any given option is not applicable to the given type
     */
    public function createBuilder($element = 'Lasouze\ListHelperBundle\Component\ListHelper\Element\ListElement', $data = null, array $options = array());    
}