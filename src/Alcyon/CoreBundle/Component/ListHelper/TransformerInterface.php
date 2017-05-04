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

use Symfony\Component\OptionsResolver\OptionsResolver;

interface TransformerInterface
{
    /**
     * Returns options
     *
     * @return array
     */
    public function getOptions();  
    
    /**
     * Set options
     *
     * @return ElementInterface
     */
    public function setOptions(array $options = array());
    
    /**
     * Configures the options
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver);
    
    /**
     * Transforms an mixed data to a string.
     *
     * @param  mixed $data the data to transform
     *
     * @return string
     */
    public function transform($data);
}