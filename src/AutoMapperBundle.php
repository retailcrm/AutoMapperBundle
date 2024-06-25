<?php

namespace Retailcrm\AutoMapperBundle;

use Retailcrm\AutoMapperBundle\DependencyInjection\Compiler\MapPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * BCCAutoMapperBundle.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class AutoMapperBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new MapPass());
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
