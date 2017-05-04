<?php

namespace Alcyon\CoreBundle\Component\Menu;

interface CreateMenuInterface 
{
	/**
	 * @return MenuItem un menu item
	*/
	public function createMenuItem() : MenuItem;
}
