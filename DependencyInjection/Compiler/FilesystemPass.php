<?php

namespace Abc\Bundle\FileDistributionBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FilesystemPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        foreach($container->findTaggedServiceIds('abc.file_distribution.filesystem') as $id => $tags)
        {
            foreach($tags as $tag)
            {
                if(!isset($tag['filesystem']))
                {
                    return;
                }

                $filesystemName         = $tag['filesystem'];
                $filesystemDefinitionId = 'abc.file_distribution.filesystem.' . $filesystemName;

                if(!$container->has($filesystemDefinitionId))
                {
                    throw new \Exception(sprintf('A filesystem with the name "%s" is not configured in app.yml (Please take a look at the documentation of the AbcFilesystemDistributionBundle)', $filesystemName));
                }

                $definition = $container->getDefinition($id);

                foreach($definition->getArguments() as $index => $argument)
                {
                    if($argument instanceof Reference && 'abc.filesystem' === (string)$argument)
                    {
                        $definition->replaceArgument($index, new Reference($filesystemDefinitionId));
                    }

                    $calls = $definition->getMethodCalls();
                    foreach ($calls as $i => $call) {
                        foreach ($call[1] as $index => $argument) {
                            if ($argument instanceof Reference && 'abc.filesystem' === (string) $argument) {
                                $calls[$i][1][$index] = new Reference($filesystemDefinitionId);
                            }
                        }
                    }
                    $definition->setMethodCalls($calls);
                }
            }
        }
    }
} 