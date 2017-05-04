<?php
namespace Tests\Alcyon\CoreBundle\Twig;

use Alcyon\CoreBundle\Service\Slugify as SlugifyService;
use Alcyon\CoreBundle\Twig\Slugify;
use PHPUnit\Framework\TestCase;

class SlugifyTest extends TestCase
{
    public function testConstructor()
    {
        $service = $this->getMockBuilder(SlugifyService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $slugify = $this->createSlugify($service);
        $this->assertSame($service, $slugify->getSlugifyService());
    }

    public function testFunctionGetFilters()
    {
        $slugify = $this->createSlugify();

        $filters = $slugify->getFilters();

        $this->assertCount(1, $filters);
        foreach ($filters as $filter) {
            $this->assertSame('slugify', $filter->getName());
            $this->assertSame([$slugify, 'slugify'], $filter->getCallable());
        }
    }

    public function testFunctionGetFunctions()
    {
        $slugify = $this->createSlugify();

        $functions = $slugify->getFunctions();

        $this->assertCount(1, $functions);
        foreach ($functions as $function) {
            $this->assertSame('slugify', $function->getName());
            $this->assertSame([$slugify, 'slugify'], $function->getCallable());
        }
    }

    public function testFunctionSlugify()
    {
        $string = 'test string to slufigy';
        $slugify = $this->createSlugify();
        $service = $slugify->getSlugifyService();

        $service->expects($this->once())
            ->method('slugify')
            ->with($this->equalTo($string))
            ->will ($this->returnValue('OK ' . $string));

        $this->assertSame('OK ' . $string, $slugify->slugify($string));
    }

    public function testFunctionGetName()
    {
        $this->assertSame('alcyon_core.slugify', $this->createSlugify()->getName());
    }

    private function createSlugify($service = null)
    {
        if (null == $service)
            $service = $this->getMockBuilder(SlugifyService::class)
                ->disableOriginalConstructor()
                ->getMock();

        $slugify = new Slugify($service);

        return $slugify;
    }
}