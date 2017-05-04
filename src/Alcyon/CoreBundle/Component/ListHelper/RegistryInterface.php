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

use Alcyon\CoreBundle\Component\ListHelper\Exception\InvalidArgumentException;

/**
 * The central registry of the ListHelper component.
 */
interface RegistryInterface
{
	/**
     * Add extension to registry.
     *
     * @param RegistryExtensionInterface 	    $extension The extension to by added
     *
     * @return RegisterInterface 	            The registry object
     */
	public function addExtension(RegistryExtensionInterface $extension);   

	/**
     * Returns a Element by name.
     *
     * @param string $name The name of the element
     *
     * @return ElementInterface The element
     *
     * @throws Exception\InvalidArgumentException if the element can not be retrieved from any extension     
     */
    public function getElement($name);
	
    /**
     * Returns whether the given list element is supported.
     *
     * @param string $name The name of the element
     *
     * @return bool Whether the element is supported
     */
    public function hasElement($name);
	
	/**
     * Returns a Element by name.
     *
     * @param ElementInterface 			$element The element to by registered
     * @param string|null 				$alias The alias of element	 
     *
     * @return RegisterInterface 	The registry object
     */
    public function addElement(ElementInterface $element, $alias = null);
}
