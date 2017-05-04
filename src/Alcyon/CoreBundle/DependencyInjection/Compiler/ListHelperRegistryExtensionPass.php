<?php

namespace Alcyon\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ListHelperRegistryExtensionPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
	public function process(ContainerBuilder $container)
    {
		// Find factory service alias
		$registryServiceAlias = $container ->getParameterBag()
								->resolveValue( $container->getParameter( ListHelperRegistryPass::AliasRegistryParameter ));
		
		// Always check if the primary service is defined	
        if (!$container->has($registryServiceAlias)) {
            return;
        }
		
		// Get factory service definition
		$registryDefinition = $container->findDefinition($registryServiceAlias);

		// find all service IDs with the listhelper.definition tag
        $taggedServices = $container->findTaggedServiceIds('listhelper.extension');		
		foreach ($taggedServices as $id => $tags) {
            // add the tagged service to registry service
            $registryDefinition->addMethodCall('addExtension', [ new Reference($id)]);
        }
	}		
}
