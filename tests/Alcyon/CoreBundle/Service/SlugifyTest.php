<?php

namespace Tests\Alcyon\CoreBundle\Service;

use Alcyon\CoreBundle\Service\Slugify;
use Alcyon\CoreBundle\Service\SlugifyProviderInterface;
use PHPUnit\Framework\TestCase;

class SlugifyTest extends TestCase
{
    const STRING = '/AZERTYazerty/*/1234567890/';
    const RULES = ['rule' => 'value'];
    const OPTIONS = [
        'regexp' => Slugify::LOWERCASE_NUMBERS_DASHES,
        'separator' => '-',
        'lowercase' => true,
    ];

    /**
     * @var Slugify
     */
    private $slugify;

    public function setUp()
    {
        $provider = $this->getMockBuilder(SlugifyProviderInterface ::class)
            ->disableOriginalConstructor()
            ->getMock();

        $provider->expects($this->once())
            ->method('getRules')
            ->will($this->returnValue(self::RULES));

        $this->slugify = new Slugify([], $provider);
    }

    public function testConstructor()
    {
        $this->assertSame(self::OPTIONS, $this->slugify->getOptions());
        $this->assertSame(self::RULES, $this->slugify->getRules());
    }

    public function testSlugifyStringToLowerCase()
    {
        $result = trim(preg_replace(Slugify::LOWERCASE_NUMBERS_DASHES,'-',mb_strtolower(self::STRING)), '-');
        $this->assertSame($result,
            $this->slugify->slugify(self::STRING));
    }

    public function testSlugifyStringOptionsDisableToLowerCase()
    {
        $result = trim(preg_replace(Slugify::LOWERCASE_NUMBERS_DASHES,'-',self::STRING), '-');
        $this->assertSame($result,
            $this->slugify->slugify(self::STRING, ['lowercase' => false]));
    }

    public function testSlugifyOptionsIsString()
    {
        $result = trim(preg_replace(Slugify::LOWERCASE_NUMBERS_DASHES,'\\',mb_strtolower(self::STRING)), '\\');
        $this->assertSame($result,
                        $this->slugify->slugify(self::STRING, '\\'));
    }
}