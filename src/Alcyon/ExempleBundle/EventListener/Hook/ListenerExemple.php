<?php

namespace Alcyon\ExempleBundle\EventListener\Hook;

use Alcyon\CoreBundle\Component\EventDispatcher\Event\DefaultEvent;

class ListenerExemple
{
    public function hookExemple(DefaultEvent $event)
    {
        // TODO : Faire un echo, un truc
        var_dump($event);
    }
}