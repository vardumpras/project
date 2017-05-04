<?php

namespace Tests\Alcyon\CoreBundle\Twig;

use Alcyon\CoreBundle\Component\ListHelper\FactoryInterface;
use Alcyon\CoreBundle\Controller\Controller;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ControllerTest extends TestCase
{

    public function testCreateListHelperFunction()
    {
        $controller = $this->getMockForAbstractClass(Controller::class);

        $controller->setContainer($this->createContainer());
        $this->assertSame('', $controller->createListHelper());

        $element = 'Alcyon\CoreBundle\Component\ListHelper\Element\ListElement';
        $data = [];
        $options = ['options'];
        $returnValue = 'returnValue';
        $controller->setContainer($this->createContainer($element, $data, $options, $returnValue));
        $this->assertSame($returnValue, $controller->createListHelper($element, $data, $options));
    }

    private function createContainer($element = 'Alcyon\CoreBundle\Component\ListHelper\Element\ListElement', $data = null, array $options = [], $returnValue = '')
    {
        $factory = $this->getMockBuilder(FactoryInterface::class)->getMock();
        $factory->expects($this->once())
            ->method('create')
            ->with($element, $data, $options)
            ->will($this->returnValue($returnValue));

        $container = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $container->expects($this->once())
            ->method('get')
            ->with('alcyon_core.component.listhelper_factory')
            ->will($this->returnValue($factory));

        return $container;
    }
}