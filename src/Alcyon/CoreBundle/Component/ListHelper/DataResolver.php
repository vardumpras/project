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

use Alcyon\CoreBundle\Component\ListHelper\Data;
use Alcyon\CoreBundle\Component\ListHelper\Exception\InvalidArgumentException;;
use Doctrine\Common\Persistence\ObjectRepository as Repository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

final class DataResolver implements DataResolverInterface
{
    /**
     * {@inheritdoc}
     */
	public function resolve( $data = Data\ArrayData::class)
	{
        // If string, try create class
        if(is_string($data)) {
            if(in_array(DataInterface::class, class_implements($data))) {
                return new $data();
            } else {
                throw new InvalidArgumentException(sprintf('The class "%s" must is a implementation of "%s"', $data, DataInterface::class));
            } 
        }        

        // If array, juste use class Data\DataArray
        if(is_array($data)) {
            return new Data\DataArray($data);
        }

        // If object, try to use Data\DoctrineData
        if(is_object($data) 
            && ( in_array(Repository::class, class_implements($data))
              || in_array(QueryBuilder::class, class_implements($data)))) {
            
            return new Data\DoctrineData($data);
        }
        
        throw new InvalidArgumentException(sprintf('Could not resolve the data object "%s"', get_class ($data)));
    }
}