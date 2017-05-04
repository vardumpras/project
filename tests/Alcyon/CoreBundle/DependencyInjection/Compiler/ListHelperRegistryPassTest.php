<?php
namespace Tests\Alcyon\CoreBundle\DependencyInjection\Compiler;

use Alcyon\CoreBundle\DependencyInjection\Compiler\ListHelperRegistryPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ListHelperRegistryPassTest extends TestCase
{
    public function testNoDefinitionRegistryFound()
    {
        $container = $this->initContainer();

        $this->process($container);
        $this->assertFalse($container->hasDefinition(ListHelperRegistryPass::AliasRegistryParameter));
    }

    private function initContainer()
    {
        // Set Parameters for list helper registry service
        $container = new ContainerBuilder();
        $container->setParameter(ListHelperRegistryPass::AliasRegistryParameter, ListHelperRegistryPass::AliasRegistryParameter);

        return $container;
    }

    private function process(ContainerBuilder $container)
    {
        $listHelperRegistryPass = new ListHelperRegistryPass();
        $listHelperRegistryPass->process($container);
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
            ->addTag('listhelper.element')
            ->setPublic(false);

        $container
            ->register('bar')
            ->addTag('listhelper.element', ['alias' => 'bar_alias'])
            ->setPublic(false);

        $this->process($container);

        $registryDefinition = $container->findDefinition(ListHelperRegistryPass::AliasRegistryParameter);

        $this->assertCount(2, $registryDefinition->getMethodCalls());

        $methodCallsResult = [
            [
                'addElement',
                ['foo', null]
            ],
            [
                'addElement',
                ['bar', 'bar_alias']
            ]
        ];

        foreach ($registryDefinition->getMethodCalls() as $id => $methodAndArgument) {
            $this->assertCount(2,$methodAndArgument); // Method and Argument

            // Test Method name
            $this->assertSame($methodCallsResult[$id][0],$methodAndArgument[0]);

            // Test argument count
            $this->assertCount(2,$methodAndArgument[1]);

            // Test First Argument is Reference class
            $this->assertInstanceOf(Reference::class,$methodAndArgument[1][0]);
            $this->assertSame($methodCallsResult[$id][1][0],$methodAndArgument[1][0]->__toString());

            // Test seconde argument is alias
            $this->assertSame($methodCallsResult[$id][1][1],$methodAndArgument[1][1]);
        }
    }
}
