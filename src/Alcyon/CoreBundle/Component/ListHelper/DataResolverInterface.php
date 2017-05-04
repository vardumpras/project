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
 * The data resolver of the ListHelper component.
 */
interface DataResolverInterface
{
	/**
     * Returns a List.
     *
     * @param mixed  $data              The initial data
     *
     * @return DataInterface            The DataInterface created
     *
     * @throws Exception\InvalidArgumentException if the data can not be resolved
     */
    public function resolve( $data);
}
