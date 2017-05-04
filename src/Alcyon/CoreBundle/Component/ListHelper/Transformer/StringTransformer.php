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

class StringTransformer extends AbstractTransformer
{
	/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        // Set Default
        $resolver->setDefaults(['prepend'           => '',
                                'append'            => '',
                                'max_length'        => 0,
                                'max_length_string' => ' ...',
                                'striptags'         => true,
                                ]);
        
        $resolver->setAllowedValues('striptags', [true, false]);
        
        // Set allowed types
        $resolver->setAllowedTypes('prepend',           'string')
                 ->setAllowedTypes('append',            'string')
                 ->setAllowedTypes('max_length',        'int')
                 ->setAllowedTypes('max_length_string', 'string');    
    } 
    
	/**
     * {@inheritdoc}
     */
    public function transform($row)
    {
        // Get resolved options
        $options = $this->getOptions();
        
        // Add prepend and append string
        $string = $options['prepend'] . $this->resolveRow($row) . $options['append'];
        
        // Strip tags
        if($options['striptags'])
            $string = strip_tags($string);
        
        // Max length
        if($options['max_length']>0 && strlen($string)>$options['max_length'])
            $string = substr($string, 0, $options['max_length']) . $options['max_length_string'];
        
        // Return parent transformed string
        return parent::transform( $string );
    }
}