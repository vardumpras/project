<?php

namespace Alcyon\CoreBundle;

use Alcyon\CoreBundle\DependencyInjection\Compiler\ListHelperRegistryExtensionPass;
use Alcyon\CoreBundle\DependencyInjection\Compiler\ListHelperRegistryPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AlcyonCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ListHelperRegistryPass());
        $container->addCompilerPass(new ListHelperRegistryExtensionPass());
    }
}
