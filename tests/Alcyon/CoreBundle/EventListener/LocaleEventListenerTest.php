<?php

namespace Tests\Alcyon\CoreBundle\EventListener;

use Alcyon\CoreBundle\EventListener\LocaleEventListener;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class LocaleEventListenerTest extends TestCase
{
    const defaultLocale = 'test';

    public function testConstructor()
    {
        $listener = new LocaleEventListener();
        $this->assertSame('fr', $listener->getDefaultLocale());

        $listener = new LocaleEventListener(self::defaultLocale);
        $this->assertSame(self::defaultLocale, $listener->getDefaultLocale());
    }

    public function testEventWithoutSession()
    {
        $request = $this->createRequest(false);

        $event = $this->createGetResponseEvent($request);

        $listener = new LocaleEventListener();
        $this->assertFalse($listener->onKernelRequest($event));
    }

    public function testRequestContainLocal()
    {
        $session = $this->createSession();
        $session->expects($this->once())
            ->method('set')
            ->with($this->equalTo('_locale'),$this->equalTo(self::defaultLocale));

        $request = $this->createRequest(true);
        $request->expects($this->once())
            ->method('get')
            ->with($this->equalTo('_locale'))
            ->will($this->returnValue(self::defaultLocale));
        $request->expects($this->once())
            ->method('getSession')
            ->will($this->returnValue($session));

        $event = $this->createGetResponseEvent($request);

        $listener = new LocaleEventListener();
        $this->assertTrue($listener->onKernelRequest($event));
    }

    public function testRequestNotContainLocal()
    {
        $sessionLocal = '$sessionLocal';
        $listener = new LocaleEventListener(self::defaultLocale);

        $session = $this->createSession();
        $session->expects($this->once())
            ->method('get')
            ->with($this->equalTo('_locale'),$this->equalTo($listener->getDefaultLocale()))
            ->will($this->returnValue($sessionLocal));

        $request = $this->createRequest(true);
        $request->expects($this->once())
            ->method('get')
            ->with($this->equalTo('_locale'))
            ->will($this->returnValue(false));
        $request->expects($this->once())
            ->method('getSession')
            ->will($this->returnValue($session));

        $request->expects($this->once())
            ->method('setLocale')
            ->with($this->equalTo($sessionLocal));

        $event = $this->createGetResponseEvent($request);


        $this->assertTrue($listener->onKernelRequest($event));
    }

    private function createRequest($hasPreviousSession)
    {
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $request->expects($this->once())
            ->method('hasPreviousSession')
            ->will($this->returnValue($hasPreviousSession));


        return $request;
    }

    private function createGetResponseEvent($request = null)
    {
        $getResponseEvent = $this->getMockBuilder(GetResponseEvent ::class)
            ->disableOriginalConstructor()
            ->getMock();

        if ($request) {
            $getResponseEvent->expects($this->once())
                ->method('getRequest')
                ->will($this->returnValue($request));
        }

        return $getResponseEvent;
    }

    private function createSession()
    {
        return $this->createMock(SessionInterface::class);
    }

}