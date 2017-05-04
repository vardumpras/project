<?php

namespace Alcyon\CoreBundle\Component\Menu;

interface MenuFactoryInterface 
{
	/** Recuperation du menu 
	 * @return MenuItem point d'entrée du menu
	*/
	public function getMenu();

}
