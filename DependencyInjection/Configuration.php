<?php

namespace Abc\Bundle\FileDistributionBundle\DependencyInjection;

use Abc\Filesystem\FilesystemType;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    private static $valid_options = array(
        FilesystemType::LOCAL => array('create', 'mode'),
        FilesystemType::FTP => array('host', 'username', 'password', 'passive', 'create', 'mode', 'ssl')
    );

    private static $required_options = array(
        FilesystemType::LOCAL => array(),
        FilesystemType::FTP => array('host')
    );

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('abc_file_distribution');

        $supportedDrivers = array('orm', 'custom');
        $validOptions = static::$valid_options;
        $requiredOptions = static::$required_options;

        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Please choose one of ' . json_encode($supportedDrivers))
                    ->end()
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('model_manager_name')
                    ->defaultNull()
                ->end()
                ->arrayNode('filesystems')
                    ->canBeUnset()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->enumNode('type')
                                ->values(FilesystemType::toArray())
                            ->end()
                            ->scalarNode('path')->isRequired()->end()
                            ->arrayNode('options')

                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->booleanNode('create')->end()
                                    ->scalarNode('mode')->end()
                                    ->scalarNode('host')->end()
                                    ->integerNode('port')->end()
                                    ->scalarNode('username')->end()
                                    ->scalarNode('password')->end()
                                    ->booleanNode('passive')->end()
                                    ->booleanNode('ssl')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->validate()
                    ->ifTrue(function($v) use ($requiredOptions, $validOptions)
                        {
                            foreach($v as $filesystem => $config)
                            {
                                $filesystemType = $config['type'];
                                $definedOptions = $config['options'];
                                foreach($requiredOptions[$filesystemType] as $name)
                                {
                                    if(!array_key_exists($name, $definedOptions))
                                    {
                                        return true;
                                    }
                                }

                                foreach($definedOptions as $name => $value)
                                {
                                    if(!in_array($name, $validOptions[$filesystemType]))
                                    {
                                        return true;
                                    }
                                }

                                return false;
                            }
                        })
                    ->then(function($v) use ($requiredOptions, $validOptions)
                        {
                            foreach($v as $filesystem => $config)
                            {
                                $filesystemType = $config['type'];
                                $definedOptions = $config['options'];
                                foreach($requiredOptions[$filesystemType] as $name)
                                {
                                    if(!array_key_exists($name, $definedOptions))
                                    {
                                        $path =  'abc_file_distribution.filesystems.' . $filesystem . '.options';
                                        $msg = sprintf('The child node "%s" at path "%s" must be configured.', $name, $path);

                                        throw new InvalidConfigurationException($msg);
                                    }
                                }

                                foreach($definedOptions as $name => $value)
                                {
                                    if(!in_array($name, $validOptions[$filesystemType]))
                                    {
                                        $path =  'abc_file_distribution.filesystems.' . $filesystem . '.options';
                                        $msg = sprintf('The option "%s" at path %s is invalid (valid options: %s).', $name, $path, implode(', ', $validOptions[$filesystemType]));

                                        throw new \InvalidArgumentException($msg);
                                    }
                                }
                            }
                        })
                ->end()
            ->end();

        $this->addDefinitionSection($rootNode);

        return $treeBuilder;
    }


    private function addDefinitionSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('definition')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('definition_manager')->defaultValue('abc.file_distribution.definition_manager.default')->end()
                    ->end()
                ->end()
            ->end();
    }
}