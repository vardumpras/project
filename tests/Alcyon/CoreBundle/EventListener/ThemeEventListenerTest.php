<?php

namespace Tests\Alcyon\CoreBundle\EventListener;

use Alcyon\CoreBundle\Entity\Dns;
use Alcyon\CoreBundle\Entity\Theme;
use Alcyon\CoreBundle\EventListener\ThemeEventListener;
use Alcyon\CoreBundle\Service\GetDns;
use Alcyon\CoreBundle\Service\GetTheme;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class ThemeEventListenerTest extends TestCase
{
    const themeName = 'ThemeName';

    private $getDns;
    private $getTheme;

    /**
     * @var ThemeEventListener
     */
    private $themeEvent;

    public function setUp()
    {
        $this->getDns = $this->getMockBuilder(GetDns ::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->getTheme = $this->getMockBuilder(GetTheme ::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->themeEvent = new ThemeEventListener($this->getDns, $this->getTheme);
    }

    public function testConstructor()
    {
        $this->assertSame($this->getDns, $this->themeEvent->getGetDns());
        $this->assertSame($this->getTheme, $this->themeEvent->getGetTheme());
    }

    public function testHaveThemeInRequest()
    {
        $request = $this->createRequest();

        $event = $this->createEvent($request);
        $request->attributes->expects($this->once())
            ->method('get')
            ->with($this->equalTo(ThemeEventListener::ATTRIBUTE_KEY), $this->equalTo(false))
            ->will($this->returnValue(true));

        $this->themeEvent->onKernelRequest($event);
        // $request->attributes = new ParameterBag([]);
    }

    private function createRequest()
    {
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $request->attributes = $this->getMockBuilder(ParameterBag::class)->getMock();

        return $request;
    }

    private function createEvent($request)
    {
        $event = $this->getMockBuilder(GetResponseEvent::class)
            ->disableOriginalConstructor()
            ->getMock();

        $event->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue($request));

        return $event;
    }

    public function testNotHaveThemeInRequest()
    {
        // Create Dns and Theme Mock
        $dns = $this->getMockBuilder(Dns::class)
            ->getMock();
        $this->getDns->expects($this->once())
            ->method('getDns')
            ->will($this->returnValue($dns));

        $theme = $this->getMockBuilder(Theme::class)
            ->getMock();
        $this->getTheme->expects($this->once())
            ->method('getTheme')
            ->with($this->equalTo($dns))
            ->will($this->returnValue($theme));

        $theme->expects($this->once())
            ->method('getTemplate')
            ->will($this->returnValue(self::themeName));

        // Create Request Mock
        $request = $this->createRequest();

        $request->attributes->expects($this->once())
            ->method('get')
            ->with($this->equalTo(ThemeEventListener::ATTRIBUTE_KEY), $this->equalTo(false))
            ->will($this->returnValue(false));

        $request->attributes->expects($this->once())
            ->method('set')
            ->with($this->equalTo(ThemeEventListener::ATTRIBUTE_KEY), self::themeName);

        // Create Event Mock
        $event = $this->createEvent($request);

        //Call event "onKernelRequest"
        $this->themeEvent->onKernelRequest($event);

    }
}