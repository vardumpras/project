<?php

namespace Tests\Alcyon\CoreBundle\Twig;

use Alcyon\CoreBundle\Component\Menu\MenuFactory;
use Alcyon\CoreBundle\Twig\Menu;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuTest extends TestCase
{
    protected $menu;
    protected $request;
    protected $menuFactory;

    public function setUp()
    {
        $this->request = $this->getMockBuilder(RequestStack::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->menuFactory = $this->getMockBuilder(MenuFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->menu = new Menu($this->request, $this->menuFactory);
    }

    public function testConstructor()
    {
        $this->assertSame($this->request, $this->menu->getRequestStack());
        $this->assertSame($this->menuFactory, $this->menu->getMenuFactory());
    }

    public function testFunctionGetFunctions()
    {
        $functions = $this->menu->getFunctions();

        $this->assertCount(1, $functions);
        foreach ($functions as $function) {
            $this->assertSame('menu', $function->getName());
            $this->assertSame([$this->menu, 'render'], $function->getCallable());

            $this->assertTrue($function->needsEnvironment());
            $this->assertSame(['html'], $function->getSafe(new \Twig_Node()));
        }
    }

    public function testFunctionMenuFilter()
    {
        $template = 'template';
        $depth = 123;
        $uri = 'uri';

        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $request->expects($this->once())
            ->method('getPathInfo')
            ->will($this->returnValue($uri));

        $this->request->expects($this->once())
            ->method('getCurrentRequest')
            ->will ($this->returnValue($request));

        $environement =  $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $environement->expects($this->once())
            ->method('render')
            ->with('template', ['menu' =>  $this->menuFactory->getMenu(),
                'uri' => $uri,
                'depth' => $depth])

            ->will ($this->returnValue($request));

        $this->menu->render($environement, $template, $depth);
    }

    public function testFunctionGetName()
    {
        $this->assertSame('alcyon_core.menu', $this->menu->getName());
    }
}