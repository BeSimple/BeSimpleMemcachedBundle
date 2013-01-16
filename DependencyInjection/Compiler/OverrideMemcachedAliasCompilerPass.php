<?php

namespace BeSimple\Bundle\MemcachedBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Reference;

class OverrideMemcachedAliasCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('be_simple.memcached.debug.traceable')) {
            return;
        }

        $container
            ->getDefinition('be_simple.memcached.debug.traceable')
            ->replaceArgument(0, new Reference((string) $container->getAlias('be_simple.memcached')))
        ;

        $container->setAlias('be_simple.memcached', new Alias('be_simple.memcached.debug.traceable'));
    }
}
