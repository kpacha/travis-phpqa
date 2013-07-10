<?php

namespace Kpacha\Travis\QaTools\Config;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class QaToolsConfiguration implements ConfigurationInterface
{

    /**
     * {@inheritdoc}
     *
     * @see \Symfony\Component\Config\Definition\ConfigurationInterface::getConfigTreeBuilder()
     */
    public function getConfigTreeBuilder()
    {
        // define configuration

        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('phpqa');

        $rootNode
            ->children()
                ->scalarNode('src_dir')
                    ->defaultValue('src')
                ->end()
                ->scalarNode('bin_dir')
                    ->defaultValue('vendor/bin')
                ->end()
                ->scalarNode('log_dir')
                    ->defaultValue('build/logs')
                ->end()
                ->scalarNode('test_dir')
                    ->defaultValue('tests')
                ->end()
                ->scalarNode('plugins')
                    ->defaultValue('phpunit')
                ->end()
            ->end();
        return $treeBuilder;
    }
}
