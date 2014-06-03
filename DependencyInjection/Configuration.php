<?php

namespace Abc\FileDistributionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * @author Wojciech Ciolko <w.ciolko@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('abc_file_distribution');

        $supportedDrivers = array('orm', 'custom');

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
            ->scalarNode('model_manager_name')->defaultNull()->end()
            ->end();


        $this->addLocationSection($rootNode);

        return $treeBuilder;
    }


    private function addLocationSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
            ->arrayNode('location')
            ->addDefaultsIfNotSet()
            ->canBeUnset()
            ->children()
            ->scalarNode('location_manager')->defaultValue('abc_file_distribution.location_manager.default')->end()
            ->end()
            ->end()
            ->end();
    }

}
