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

use Alcyon\CoreBundle\Component\ListHelper\ElementInterface;
use Alcyon\CoreBundle\Component\ListHelper\Util\StringUtil;
use Alcyon\CoreBundle\Component\ListHelper\Options\AbstractOptions;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class BaseElement extends AbstractElement
{
	/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        
        $resolver->setDefaults([
                    'disabled'  => false,
                    'class'     => "",
                    'attr'      => [],
                    'tags'      => '',
                    ])
        ;
        
        // Set allowed values
        $resolver->setAllowedValues('disabled', [true, false]);
        
        // Set allowed types
        $resolver->setAllowedTypes('class', 'string')
                 ->setAllowedTypes('attr', 'array')
                 ->setAllowedTypes('tags', ['string','array']);
                 
        $resolver->setNormalizer('attr', function (Options $options, $attr) {
            
                // Verify all attr are string => string
                foreach($attr as $key => $value) {
                    if(!is_string($key) || !is_string($value))
                        throw new UnexpectedTypeException($attr, 'array of string => string');   
                }

                return $attr;
            })
            ->setNormalizer('tags', function (Options $options, $tags) {
                
                if(is_string($tags))
                    $tags = array($tags);
                    
                // Verify all tags are string => string
                foreach($tags as $key => $value) {
                    if(!is_string($key) || !is_string($value))
                        throw new UnexpectedTypeException($attr, 'array of string');   
                }

                return $tags;
        })
        ;                 
    } 
}
