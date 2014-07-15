<?php

namespace Abc\Bundle\FileDistributionBundle;

use Abc\Bundle\FileDistributionBundle\DependencyInjection\Compiler\FilesystemPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AbcFileDistributionBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FilesystemPass());
    }
}