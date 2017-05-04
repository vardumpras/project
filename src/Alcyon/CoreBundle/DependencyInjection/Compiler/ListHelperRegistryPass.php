<?php

namespace Alcyon\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ListHelperRegistryPass implements CompilerPassInterface
{
    const AliasRegistryParameter = 'alcyon_core.component.listhelper_registry';

    /**
     * {@inheritdoc}
     */
	public function process(ContainerBuilder $container)
    {
		// Find factory service alias
		$registryServiceAlias = $container ->getParameterBag()
								->resolveValue( $container->getParameter( self::AliasRegistryParameter));

		// Always check if the primary service is defined	
        if (!$container->hasDefinition($registryServiceAlias)) {
            return;
        }
		
		// Get factory service definition
		$registryDefinition = $container->findDefinition($registryServiceAlias);

		// find all service IDs with the listhelper.definition tag
        $taggedServices = $container->findTaggedServiceIds('listhelper.element');		
		foreach ($taggedServices as $id => $tags) {
            foreach($tags as $tag) {
                // add the tagged service to register service
                $registryDefinition->addMethodCall('addElement', [new Reference($id),
                    isset($tag['alias']) ? $tag['alias'] : null]);
            }
        }	
	}		
}
