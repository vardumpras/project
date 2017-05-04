<?php

namespace Tests\Alcyon\CoreBundle;

use Alcyon\CoreBundle\AlcyonCoreBundle;
use Alcyon\CoreBundle\DependencyInjection\Compiler\ListHelperRegistryExtensionPass;
use Alcyon\CoreBundle\DependencyInjection\Compiler\ListHelperRegistryPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AlcyonCoreBundleTest extends TestCase
{

    public function testBuildFunction()
    {
        $container = $this->getMockBuilder(ContainerBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $container->expects($this->exactly(2))
            ->method('addCompilerPass')
            ->withConsecutive(
                $this->isInstanceof(ListHelperRegistryPass::class),
                $this->isInstanceof(ListHelperRegistryExtensionPass::class)
            );

        $bundle = new AlcyonCoreBundle();
        $bundle->build($container);
    }
}