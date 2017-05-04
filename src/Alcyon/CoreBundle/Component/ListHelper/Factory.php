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

use Symfony\Component\Form\FormFactoryInterface;

final class Factory implements FactoryInterface
{
    /**
     * @var RegistryInterface
     */
    private $registry;
    
	/**
     * @var DataResolverInterface
     */
    private $dataResolver;  
    
	/**
     * @var FormFactoryInterface
     */
    private $formFactory;   
    
    /**
     * Constructor.
     *
     * @param RegistryInterface         $registry       The registry for find elements
     * @param DataResolverInterface     $dataResolver   The data resolver form builder
     * @param FormFactoryInterface      $formFactory    The form factory
     */	
    public function __construct(RegistryInterface $registry, DataResolverInterface $dataResolver, FormFactoryInterface $formFactory)
    {
        $this->registry     = $registry;
        $this->dataResolver = $dataResolver;
        $this->formFactory  = $formFactory;
    } 
    
    /**
     * {@inheritdoc}
     */
    public function create($element = 'Alcyon\CoreBundle\Component\ListHelper\Element\ListElement', $data = null, array $options = array())
    {
        return $this->createBuilder($element, $data, $options)->createList();
    }
    
    /**
     * {@inheritdoc}
     */
    public function createBuilder($element = 'Lasouze\ListHelperBundle\Component\ListHelper\Element\ListElement', $data = null, array $options = array())
    {
	    if (!is_string($element)) {
            throw new UnexpectedTypeException($element, 'string');
        }
		
        if (null !== $data && !array_key_exists('data', $options)) {
            $options['data'] = $data;
        }

        $element = $this->registry->getElement($element);
        
        $builder =  new Builder($this->registry, $this->dataResolver, $this->formFactory, $element, $options);

        return $builder;
        
    }    
}