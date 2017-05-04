<?php

namespace Tests\Alcyon\CoreBundle\Service;

use Alcyon\CoreBundle\Service\RevCrypt;
use PHPUnit\Framework\TestCase;


class RevCryptTest extends TestCase
{
    /**
     * @dataProvider codeProvider
     */
    public function testCode($key, $value, $result)
    {
        $revCrypt = new RevCrypt();

        $this->assertSame($result, $revCrypt->code($key, $value));
    }

    /**
     * @dataProvider codeProvider
     */
    public function testDecode($key, $result, $value)
    {
        $revCrypt = new RevCrypt();

        $this->assertSame($result, $revCrypt->decode($key, $value));
    }

    public function codeProvider()
    {
        return [
            ['sdfsdfsdfsdf', 'sdfsdfsdfsdf', 'G04rsEL81D5a7ab0'],
            ['dfgfgdfgdf', 'ghjgddfghjghjghj1', 'RBJ7AfAm81WfhacSvmlgxAM='],
            ['logiciel?0103054123456', 'password', 's08A0WFBTdg='],
        ];
    }
}