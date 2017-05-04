<?php
/**
 * Created by PhpStorm.
 * User: ddesousa
 * Date: 15/03/2017
 * Time: 11:37
 */

namespace Tests\Alcyon\CoreBundle\DependencyInjection\Compiler;
use Alcyon\CoreBundle\DependencyInjection\Compiler\ListHelperRegistryExtensionPass;
use Alcyon\CoreBundle\DependencyInjection\Compiler\ListHelperRegistryPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ListHelperRegistryExtensionPassTest extends TestCase
{
    private function initContainer()
    {
        // Set Parameters for list helper registry service
        $container = new ContainerBuilder();
        $container->setParameter(ListHelperRegistryPass::AliasRegistryParameter, ListHelperRegistryPass::AliasRegistryParameter);

        return $container;
    }

    public function testNoDefinitionRegistryFound()
    {
        $container = $this->initContainer();

        $this->process($container);
        $this->assertFalse($container->hasDefinition(ListHelperRegistryPass::AliasRegistryParameter));
    }

    private function process(ContainerBuilder $container)
    {
        $listHelperRegistryExtensionPass = new ListHelperRegistryExtensionPass();
        $listHelperRegistryExtensionPass->process($container);
    }

    public function testWithoutDefinitionToAdd()
    {
        $container = $this->initContainer();

        // Add fake list helper registry service
        $container
            ->register(ListHelperRegistryPass::AliasRegistryParameter)
            ->setPublic(false);

        // Add some service
        $container
            ->register('foo')
            ->setPublic(false);
        $this->process($container);

        $registryDefinition = $container->findDefinition(ListHelperRegistryPass::AliasRegistryParameter);

        $this->assertCount(0, $registryDefinition->getMethodCalls());

    }

    public function testWithDefinitionToAdd()
    {
        $container = $this->initContainer();

        // Add fake list helper registry service
        $container
            ->register(ListHelperRegistryPass::AliasRegistryParameter)
            ->setPublic(false);

        // Add service for registry service
        $container
            ->register('foo')
            ->setPublic(false);

        $container
            ->register('bar')
            ->addTag('listhelper.extension')
            ->setPublic(false);

        $this->process($container);

        $registryDefinition = $container->findDefinition(ListHelperRegistryPass::AliasRegistryParameter);

        $this->assertCount(1, $registryDefinition->getMethodCalls());

        $methodCallsResult = [
            [
                'addExtension',
                ['bar']
            ]
        ];

        foreach ($registryDefinition->getMethodCalls() as $id => $methodAndArgument) {
            $this->assertCount(2, $methodAndArgument); // Method and Argument

            // Test Method name
            $this->assertSame($methodCallsResult[$id][0], $methodAndArgument[0]);

            // Test argument count
            $this->assertCount(1, $methodAndArgument[1]);

            // Test Argument is Reference class
            $this->assertInstanceOf(Reference::class, $methodAndArgument[1][0]);
            $this->assertSame($methodCallsResult[$id][1][0], $methodAndArgument[1][0]->__toString());


        }
    }
}