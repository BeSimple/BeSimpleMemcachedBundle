<?php

namespace BeSimple\Bundle\MemcachedBundle;

use BeSimple\Bundle\MemcachedBundle\DependencyInjection\Compiler\OverrideMemcachedAliasCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BeSimpleMemcachedBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new OverrideMemcachedAliasCompilerPass());

        parent::build($container);
    }
}
