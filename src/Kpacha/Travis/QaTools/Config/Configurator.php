<?php

namespace Kpacha\Travis\QaTools\Config;

use Satooshi\Component\File\Path;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Yaml;

/**
 * Coveralls API configurator.
 *
 * @author Kitamura Satoshi <with.no.parachute@gmail.com>
 */
class Configurator
{
    // API

    /**
     * Load configuration.
     *
     * @param string $coverallsYmlPath Path to .coveralls.yml.
     * @param string $rootDir          Path to project root directory.
     *
     * @return \Kpacha\Travis\QaTools\Config\Configuration
     *
     * @throws \Symfony\Component\Yaml\Exception\ParseException If the YAML is not valid
     */
    public function load($coverallsYmlPath, $rootDir)
    {
        $yml = $this->parse($coverallsYmlPath);
        $options = $this->process($yml);

        return $this->createConfiguration($options, $rootDir);
    }

    // Internal method

    /**
     * Parse .coveralls.yml.
     *
     * @param string $coverallsYmlPath Path to .coveralls.yml.
     *
     * @return array
     *
     * @throws \Symfony\Component\Yaml\Exception\ParseException If the YAML is not valid
     */
    protected function parse($coverallsYmlPath)
    {
        $file = new Path();
        $path = realpath($coverallsYmlPath);

        if ($file->isRealFileReadable($path)) {
            $yml = Yaml::parse($path);

            return empty($yml) ? array() : $yml;
        }

        return array();
    }

    /**
     * Process parsed configuration according to the configuration definition.
     *
     * @param array $yml Parsed configuration.
     *
     * @return array
     */
    protected function process(array $yml)
    {
        $processor = new Processor();

        return $processor->processConfiguration(new QaToolsConfiguration, array('qatools' => $yml));
    }

    /**
     * Create coveralls configuration.
     *
     * @param array  $options Processed configuration.
     * @param string $rootDir Path to project root directory.
     *
     * @return Configuration
     */
    protected function createConfiguration(array $options, $rootDir)
    {
        $configuration = new Configuration();

        $rootDir = realpath($rootDir) . '/';

        return $configuration
                        ->setRootDir($rootDir)
                        ->setSrcDir($rootDir . $options['src_dir'])
                        ->setBinDir($rootDir . $options['bin_dir'])
                        ->setLogDir($rootDir . $options['log_dir'])
                        ->setTestDir($rootDir . $options['test_dir'])
                        ->setEnabledPlugins(explode(',', $options['plugins']))
        ;
    }

}

