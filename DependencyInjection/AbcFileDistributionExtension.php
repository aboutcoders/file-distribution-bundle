<?php

namespace Abc\Bundle\FileDistributionBundle\DependencyInjection;

use Abc\File\Filesystem;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AbcFileDistributionExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config/services'));


        if ('custom' !== $config['db_driver']) {
            $loader->load(sprintf('%s.xml', $config['db_driver']));
        }

        $this->remapParametersNamespaces($config, $container, array(
            '' => array(
                'db_driver'          => 'abc.file_distribution.storage',
                'model_manager_name' => 'abc.file_distribution.model_manager_name'
            )
        ));

        if (!empty($config['filesystem'])) {
            $this->loadFilesystem($config['filesystem'], $container, $loader, $config['db_driver']);
        }


        $loader->load('service.xml');

        if (isset($config['filesystems']))
        {
            foreach ($config['filesystems'] as $name => $filesystem)
            {
                $definitionId = 'abc.file_distribution.filesystem.' . $name;
                $filesystemDef = new DefinitionDecorator('abc.file_distribution.filesystem.prototype');
                $filesystemDef->addMethodCall('setType', array($filesystem['type']));
                $filesystemDef->addMethodCall('setPath', array($filesystem['path']));
                // TODO:  $job->replaceArgument(2, $options);
                $container->setDefinition($definitionId, $filesystemDef);

                $definition = new Definition('Abc\File\FilesystemClient', array(new Reference('abc.file_distribution.adapter_factory'), new Reference($definitionId)));

                $container->setDefinition('abc.file_distribution.client.'.$name, $definition);
            }
        }
    }


    private function loadFilesystem(array $config, ContainerBuilder $container, XmlFileLoader $loader, $dbDriver)
    {
        if ('custom' !== $dbDriver) {
            $loader->load(sprintf('%s_filesystem.xml', $dbDriver));
        }

        $container->setAlias('abc.file_distribution.filesystem_manager', $config['filesystem_manager']);

        $this->remapParametersNamespaces($config, $container, array(
            '' => array(
                'filesystem_class' => 'abc.file_distribution.model.filesystem.class',
            )
        ));
    }


    protected function remapParameters(array $config, ContainerBuilder $container, array $map)
    {
        foreach ($map as $name => $paramName) {
            if (array_key_exists($name, $config)) {
                $container->setParameter($paramName, $config[$name]);
            }
        }
    }

    protected function remapParametersNamespaces(array $config, ContainerBuilder $container, array $namespaces)
    {
        foreach ($namespaces as $ns => $map) {
            if ($ns) {
                if (!array_key_exists($ns, $config)) {
                    continue;
                }
                $namespaceConfig = $config[$ns];
            } else {
                $namespaceConfig = $config;
            }
            if (is_array($map)) {
                $this->remapParameters($namespaceConfig, $container, $map);
            } else {
                foreach ($namespaceConfig as $name => $value) {
                    $container->setParameter(sprintf($map, $name), $value);
                }
            }
        }
    }
}
