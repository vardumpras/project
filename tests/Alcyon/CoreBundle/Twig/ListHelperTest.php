<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 26/04/2017
 * Time: 11:53
 */

namespace Tests\Alcyon\CoreBundle\Twig;

use Alcyon\CoreBundle\Component\ListHelper\ListView;
use Alcyon\CoreBundle\Twig\ListHelper;
use PHPUnit\Framework\TestCase;

class ListHelperTest extends TestCase
{
    const template = 'My template';

    public function testConstructor()
    {
        $listHelper = new ListHelper(self::template);
        $this->assertSame(self::template, $listHelper->getTemplate());
    }

    public function testCreateFunction()
    {
        $listHelper = new ListHelper(self::template);
        $function = $listHelper->createFunction('function');

        $this->assertSame('function', $function->getName());
        $this->assertSame([$listHelper, 'function'], $function->getCallable());
        $this->assertTrue($function->needsEnvironment());
        $this->assertSame(['html'], $function->getSafe(new \Twig_Node()));

    }

    public function testGetFunctions()
    {
        $listHelper = new ListHelper(self::template);

        $this->assertSame(count($listHelper->getFunctions()), count(ListHelper::FUNCTION_LIST));

        foreach ($listHelper->getFunctions() as $function) {
            $this->assertTrue(in_array($function->getName(), ListHelper::FUNCTION_LIST));

            $this->assertSame([$listHelper, $function->getName()], $function->getCallable());
            $this->assertTrue($function->needsEnvironment());
            $this->assertSame(['html'], $function->getSafe(new \Twig_Node()));
        }
    }

    public function testUndefinedFunctionException()
    {
        $listHelper = new ListHelper(self::template);

        $this->expectException(\InvalidArgumentException::class);
        $listHelper->__call('methode', []);
    }

    public function testFirstArgumentNotInstantOfTwigEnvironmentException()
    {
        $listHelper = new ListHelper(self::template);

        $this->expectException(\InvalidArgumentException::class);
        $listHelper->__call(ListHelper::FUNCTION_LIST[0], ['test']);
    }

    public function testSecondeArgumentNotInstantOfListViewException()
    {
        $environement =  $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $listHelper = new ListHelper(self::template);

        $this->expectException(\InvalidArgumentException::class);
        $listHelper->__call(ListHelper::FUNCTION_LIST[0], [$environement, 'test']);
    }

    public function testCallListViewAuto()
    {
        $renderedBlock = 'My rendered block';

        foreach (ListHelper::FUNCTION_LIST as $method) {
            $listView = $this->getMockBuilder(ListView::class)
                ->disableOriginalConstructor()
                ->getMock();

            $templating = $this->getMockBuilder(\Twig_Template::class)
                ->disableOriginalConstructor()
                ->getMock();
            $templating->expects($this->once())
                ->method('renderBlock')
                ->with($method, ['list' => $listView])
                ->will($this->returnValue($renderedBlock));

            $environement = $this->getMockBuilder(\Twig_Environment::class)
                ->disableOriginalConstructor()
                ->getMock();
            $environement->expects($this->once())
                ->method('loadTemplate')
                ->with(self::template)
                ->will($this->returnValue($templating));

            $listHelper = new ListHelper(self::template);
            $this->assertSame($renderedBlock, $listHelper->__call($method, [$environement, $listView]));
        }
    }

    public function testFunctionGetName()
    {
        $this->assertSame('alcyon_core.listhelper', (new ListHelper(self::template))->getName());
    }
}