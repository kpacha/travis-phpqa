<?php

namespace Kpacha\Travis\QaTools\Config;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Definition of .coveralls.yml configuration.
 *
 * # same as ruby
 * repo_token: your-token
 * repo_secret_token: your-token
 * service_name: travis-pro
 *
 * # for php
 * src_dir: src
 * coverage_clover: build/logs/clover.xml
 * json_path: build/logs/coveralls-upload.json
 *
 */
class QaToolsConfiguration implements ConfigurationInterface
{
    // ConfigurationInterface

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
