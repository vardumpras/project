<?php 

namespace Alcyon\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as SymfonyController;

abstract class Controller extends SymfonyController
{
	/**
     * Returns a List.
     *
     * @param string $element The element of the list
     * @param mixed  $data    The initial data
     * @param array  $options The options
     *
     * @return ListHelper The list created
     */
	public function createListHelper($element = 'Alcyon\CoreBundle\Component\ListHelper\Element\ListElement', $data = null, array $options = [])
    {
        return $this->get('alcyon_core.component.listhelper_factory')->create($element, $data, $options);
    }
}