<?php

namespace Retailcrm\AutoMapperBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * MapPass registers the tagged maps with the mapper.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class MapPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if ($container->hasDefinition('auto_mapper.mapper')) {
            $definition = $container->getDefinition('auto_mapper.mapper');
            foreach ($container->findTaggedServiceIds('auto_mapper.map') as $id => $attributes) {
                $definition->addMethodCall('registerMap', [new Reference($id)]);
            }
        }
    }
}
