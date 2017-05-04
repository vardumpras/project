<?php

/*
 * This file is part of the AlcyonCoreBundle package.
 *
 * (c) David DE SOUSA <d.desousa@alcyon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Alcyon\CoreBundle\Component\ListHelper\Element;

use Alcyon\CoreBundle\Component\ListHelper\Filter;
use Alcyon\CoreBundle\Component\ListHelper\Transformer;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ColumnElement extends ListElement
{
	/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        
        // Set default
        $resolver->setDefaults([
                        'filter'            => Filter\TextFilter::class,
                        'allow_order'       => true,
                        'tags'              => 'column',
                        'transformer'       => Transformer\StringTransformer::class
                    ]
        );

        // Set allowed values
        $resolver->setAllowedValues('allow_order', [true, false]);    
    }
}