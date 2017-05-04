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

/**
 * The ElementInterface of the ListHelper component.
 */
interface ElementInterface
{    
    /**
     * Set the registry 
     *
     * @param RegistryInterface   	$registry
     *
     * @return ElementInterface The object
     */
    public function setRegistry(RegistryInterface $registry);
    
    /**
     * Configures the options
     *
     * @param OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver);
    
	/**
     * Builds the list.
     *
     *
     * @param BuilderInterface      $builder The build
     * @param array                 $options The options
     */    
    public function buildList(BuilderInterface $builder, array $options);    
    
	/**
     * Builds the list.
     *
     *
     * @param ListView          $view The list view to finish
     *
     * @return ElementInterface The current object     
     */    
    public function finishView(ListView $view);
    
    /**
     * Returns the name for this element.
     *
     * @return string The name
     */
    public function getName();
}
