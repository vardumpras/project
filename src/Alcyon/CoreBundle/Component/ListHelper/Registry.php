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

use Alcyon\CoreBundle\Component\ListHelper\Exception\InvalidArgumentException;

final class Registry implements RegistryInterface
{
	/**
     * @var ElementInterface[]
     */
    private $unresolvedElements = [];
    
	/**
     * @var ElementInterface[]
     */
    private $elements = [];    
    
    /**
     * @var RegistryExtensionInterface[]
     */
    private $extensions = [];
	
    /**
     * {@inheritdoc}
     */	
	public function addExtension(RegistryExtensionInterface $extension)
	{
		$this->extensions[] = $extensions;
		
		return $this;
	}    

    /**
     * {@inheritdoc}
     */	
	public function getElement($name)
	{
		if(!isset($this->element[$name])) {

            $element = null;
            if(isset($this->unresolvedElements[$name])) {
                $element = $this->unresolvedElements[$name];
                unset($this->unresolvedElements[$name]);
            }
            
            $this->resolveElement($element, $name);
            
            if(null == $element) {
            
                if(!in_array('Alcyon\CoreBundle\Component\ListHelper\ElementInterface', class_implements($name))) {
                    throw new InvalidArgumentException(sprintf('Could not load element "%s"', $name));
                }
                
                $element = new $name();
            }
            
            $element->setRegistry($this);
            
			$this->element[$name] = $element;
		}
		
		return $this->element[$name];
	}
	
    /**
     * {@inheritdoc}
     */
    public function hasElement($name)
    {
        if (isset($this->elements[$name])) {
            return true;
        }

        try {
            $this->getElement($name);
        } catch (ExceptionInterface $e) {
            return false;
        }

        return true;
    }
	
    /**
     * {@inheritdoc}
     */	
	public function addElement(ElementInterface $element, $alias = null)
	{
        // Add to unresolved element
        $this->unresolvedElements[get_class($element)] = $element;
        
        if(null === $alias && get_class($element) !== $alias) {
			$this->unresolvedElements[get_class($alias)] = $element;
		}
		
		return $this;
	}
	
	/**
	 * Extende a element by calling all extensions
     *
     * @param ElementInterface|null $element The element to extend
     * @param string $name          The name of element to extend
     *
     * @return ElementInterface The resolved element
     */
    private function resolveElement(ElementInterface $element = null, $name)
    {
        $element = null;
        
        foreach($this->extensions as $extension) {
            $element = $extension->extend($element, $name);
        }

        return $element;
    }
}
