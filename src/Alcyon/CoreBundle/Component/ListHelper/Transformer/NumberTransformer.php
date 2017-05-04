<?php

/*
 * This file is part of the AlcyonCoreBundle package.
 *
 * (c) David DE SOUSA <d.desousa@alcyon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Alcyon\CoreBundle\Component\ListHelper\Transformer;

use Symfony\Component\OptionsResolver\OptionsResolver;

class NumberTransformer extends StringTransformer
{
	/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        // Set Default
        $resolver->setDefaults(['decimals'              => 0,
                                'decimal_separator'     => '.',
                                'thousands_separator'   => ',',
                                ]);
         
        // Set allowed types
        $resolver->setAllowedTypes('decimals',            'int')
                 ->setAllowedTypes('decimal_separator',   'string')
                 ->setAllowedTypes('thousands_separator', 'string');    
    } 
    
	/**
     * {@inheritdoc}
     */
    public function transform($row)
    {
        // Get resolved options
        $options = $this->getOptions();
        
        //number format using options
        $string = number_format($this->resolveRow($row), $options['decimals'], $options['decimal_separator'], $options['thousands_separator']);
        
        // Return parent transformed string
        return parent::transform( $string );
    }
}