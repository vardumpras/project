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

use Alcyon\CoreBundle\Component\ListHelper\TransformerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractTransformer implements TransformerInterface
{
    /**
     * @var array
     */
    private $options = null;
    
	/**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        if(null == $this->options) {
            $this->setOptions();
        }

        return $this->options;
    } 
    
    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        
        $this->options = $resolver->resolve($options);
        
        return $this;
    }
    
	/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // Set required
        $resolver->setRequired('field');

        // Set allowed types
        $resolver->setAllowedTypes('field', 'string');    
    }
    
	/**
     * {@inheritdoc}
     */
    public function transform($row)
    {
        // Return resolved string
        return $this->resolveRow($row) ;
    }  
    
    /**
     * Resolve a data to a string using array access of getters
     *
     * @param  mixed $row the data to Convert
     *
     * @return string
     */    
    protected function resolveRow($row)
    {
        // Return string
        if(is_string($row)) {
            return $row;
        }
        
        // Get field 
        $field = ($this->getOptions())['field'];
        
        // Try to access using array
        if(is_array($row)) {
            return $row[ $field ];
        }   
        
        // Try to access using getters
        if(is_object($row)) {
            $method = null;
            if(method_exists($row, 'get'.$field)) {
                $method = 'get'.$field;
            }
            
            if(method_exists($row, 'get'.ucfirst($field))) {
                $method = 'get'.ucfirst($field);
            } 
            
            if(method_exists($row, 'is'.$field)) {
                $method = 'is'.$field;
            }  
            if(method_exists($row, 'is'.ucfirst($field))) {
                $method = 'is'.ucfirst($field);
            }              
            
            if(null !== $method)
                return $row->$method();
        }
        
        return '';
    }
}
