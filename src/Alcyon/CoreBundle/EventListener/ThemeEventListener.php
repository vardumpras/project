<?php

namespace Alcyon\CoreBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Alcyon\CoreBundle\Service\GetDns;
use Alcyon\CoreBundle\Service\GetTheme;

class ThemeEventListener extends EventListener
{
     /**
     * @var clé
     */
    const ATTRIBUTE_KEY = 'theme_name';

    private $getDns;
    private $getTheme;

    /**
     * @return GetDns
     */
    public function getGetDns(): GetDns
    {
        return $this->getDns;
    }

    /**
     * @return GetTheme
     */
    public function getGetTheme(): GetTheme
    {
        return $this->getTheme;
    }

    public function __construct(GetDns $getDns, GetTheme $getTheme) // this is @service_container
    {
        $this->getDns = $getDns;
        $this->getTheme = $getTheme;
    }

    /**
     * Kick for use good theme.
     *
     * @param GetResponseEvent $event
     */

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->attributes->get(static::ATTRIBUTE_KEY, false) === false) {

            // Get DNS entity using service
            $dns = $this->getDns->getDns();

            // Get Theme entity using service
            $theme = $this->getTheme->getTheme($dns);
            
            // Set Template name
            $request->attributes->set(static::ATTRIBUTE_KEY, $theme->getTemplate());

        } 
    }
}
