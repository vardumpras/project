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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

final class ListHelper
{
    /**
     * @var string
     */	
    private $name;
    
    /**
     * @var array
     */	
    private $options;    
    
    /**
     * @var Elementinterface
     */
    private $element = null;
    
    /**
     * @var ListHelper[]
     */
    private $children = array();    
       
    /**
     * @var FormInterface
     */
    private $form = null;
    
    /**
     * Constructor.
     *
     * @param string            $name       The name of this listHelper
     * @param array             $options    The options of this listHelper
     * @param ElementInterface  $element    The element of this listHelper for creating listView   
     */	
    public function __construct($name, array $options = [], ElementInterface $element)
    {
        $this->name = $name;
        $this->options = $options;
        $this->element = $element;
    } 
    
    /**
     * Adds a new element to this group. A element must have a unique name within
     * the group. Otherwise the existing element is overwritten.
     *
     * @param string   	$name
     * @param ListHelper 	$element
     *
     * @return ListHelper The object
     */
    public function add($name, ListHelper $element)
    {
        $this->children[$name] = $element;

        $options = $element->getOptions();
        
        if(isset($options['filter']) 
            && $options['filter'] instanceof FilterInterface 
            && null !== $this->getForm()) {
            $options['filter']->addToForm($name, $this->getForm());
            
            if(isset($this->options['data']) 
                && $this->options['data'] instanceof DataInterface ) {
                $this->options['data']->addFilter($name, $options['filter']);
            }
        }
            
        return $this;
    }
    
    /**
     * Set FormInterface
     *
     * @return ListView
     */
    public function setForm(FormInterface $form)
    {
        $this->form  = $form;
        
        return $this;
    }
    
    /**
     * Get form of this ListHelper
     *
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    } 
    
    /**
     * Get options of this ListHelper
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    /**
     * Handle the Request to all child
     *
     * @return ListHelper
     */
    public function handleRequest(Request $request)
    {
        if(null != $this->form)
            $this->form->handleRequest($request);
        
        foreach($this->children as $name => $element)
            $element->handleRequest($request);
    }

    /**
     * {@inheritdoc}
     */
    public function getTags()
    {
        $tags = array();

        // Children tags
        foreach($this->children as $name => $element) {
            $tags = array_merge($tags, array_diff($element->getTags(), $tags));
        }

        // element tags
        if(isset($this->options['tags']))
            $tags = array_merge($tags, $this->options['tags']);

        return $tags;
    }

    /**
     * Returns a ListView
     *
     * @return ListHelper The list created
     */
    public function createView()
    {
        $listView = new ListView();
        $listView->name = $this->name;
        $listView->vars = $this->options;

        if(null != $this->form)
            $listView->form = $this->form->createView();
        
        foreach($this->children as $name => $element)
            $listView->children[$name] = $element->createView();
        
        $this->element->finishView($listView);
        
        return $listView;
    }    
}