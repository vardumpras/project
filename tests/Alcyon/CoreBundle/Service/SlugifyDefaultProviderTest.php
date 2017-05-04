<?php

namespace Tests\Alcyon\CoreBundle\Service;

use Alcyon\CoreBundle\Service\SlugifyDefaultProvider;
use Alcyon\CoreBundle\Service\SlugifyProviderInterface;
use PHPUnit\Framework\TestCase;

class SlugifyDefaultProviderTest extends TestCase
{
    public function testInterface()
    {
        $provider = new SlugifyDefaultProvider();

        $this->assertTrue($provider instanceof SlugifyProviderInterface);
        $this->assertCount(111, $provider->getRules());

    }
}