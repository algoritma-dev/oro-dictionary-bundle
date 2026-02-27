<?php

namespace Algoritma\Bundle\DictionaryBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('algoritma_dictionary');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('api_key')
                    ->cannotBeEmpty()
                    ->isRequired()
                ->end()
                ->scalarNode('client')->defaultValue('google')->end()
             ->end()
        ;

        return $treeBuilder;
    }
}