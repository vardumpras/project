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
 * The registry extension  form the ListHelper component.
 */
interface RegistryExtensionInterface
{
	/**
     * Extend a Element by name.
     *
     * @param string $name The name of the element
     *
     * @return ElementInterface The element
     *
     * @throws Exception\InvalidArgumentException if the element can not be extended
     */
    public function extend($name);
}