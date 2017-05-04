<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 25/04/2017
 * Time: 09:36
 */

namespace Tests\Alcyon\CoreBundle\Twig;

use Alcyon\CoreBundle\Twig\Regex;
use PHPUnit\Framework\TestCase;

class RegexTest extends TestCase
{
    public function testFunctionGetFilters()
    {
        $regex = new Regex();

        $filters = $regex->getFilters();

        $this->assertCount(1, $filters);
        foreach ($filters as $filter) {
            $this->assertSame('regex', $filter->getName());
            $this->assertSame([$regex, 'regex'], $filter->getCallable());
        }
    }

    public function testFunctionGetFunctions()
    {
        $regex = new Regex();

        $functions = $regex->getFunctions();

        $this->assertCount(1, $functions);
        foreach ($functions as $function) {
            $this->assertSame('regex', $function->getName());
            $this->assertSame([$regex, 'regex'], $function->getCallable());
        }
    }

    /**
     * @dataProvider dataForTestFunctionRegexDataProvider
     */
    public function testFunctionRegex($string, $find, $replace, $result)
    {
        $regex = new Regex();
        $this->assertSame($result, $regex->regex($string, $find, $replace));
    }

    public function dataForTestFunctionRegexDataProvider()
    {
        return [
            [true, '','', true],
            ['test string','','','test string'],
            ['test string','#string#','','test '],
        ];
    }

    public function testFunctionGetName()
    {
        $this->assertSame('alcyon_core.regex', (new Regex())->getName());
    }
}