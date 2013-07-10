<?php

namespace Kpacha\Travis\QaTools\Config;

class Configuration
{

    /**
     * Absolute path to root directory.
     *
     * @var string
     */
    protected $rootDir;

    /**
     * Absolute path to src directory.
     *
     * @var string
     */
    protected $srcDir;

    /**
     * Absolute path to vendor/bin directory.
     *
     * @var string
     */
    protected $binDir;

    /**
     * Absolute path to the log directory.
     *
     * @var string
     */
    protected $logDir;

    /**
     * Absolute path to the test directory.
     *
     * @var string
     */
    protected $testDir;

    /**
     * Set of plugins to execute.
     *
     * @var array
     */
    protected $enabledPlugins = array();

    public function getRootDir()
    {
        return $this->rootDir;
    }

    /**
     * @param string $rootDir
     * @return \Kpacha\Travis\QaTools\Config\Configuration
     */
    public function setRootDir($rootDir)
    {
        $this->rootDir = $rootDir;
        return $this;
    }

    public function getSrcDir()
    {
        return $this->srcDir;
    }

    /**
     * @param string $srcDir
     * @return \Kpacha\Travis\QaTools\Config\Configuration
     */
    public function setSrcDir($srcDir)
    {
        $this->srcDir = $srcDir;
        return $this;
    }

    public function getBinDir()
    {
        return $this->binDir;
    }

    /**
     * @param string $binDir
     * @return \Kpacha\Travis\QaTools\Config\Configuration
     */
    public function setBinDir($binDir)
    {
        $this->binDir = $binDir;
        return $this;
    }

    public function getLogDir()
    {
        return $this->logDir;
    }

    /**
     * @param string $logPaths
     * @return \Kpacha\Travis\QaTools\Config\Configuration
     */
    public function setLogDir($logPaths)
    {
        $this->logDir = $logPaths;
        return $this;
    }

    public function getTestDir()
    {
        return $this->testDir;
    }

    /**
     * @param string $testDir
     * @return \Kpacha\Travis\QaTools\Config\Configuration
     */
    public function setTestDir($testDir)
    {
        $this->testDir = $testDir;
        return $this;
    }

    public function getEnabledPlugins()
    {
        return $this->enabledPlugins;
    }

    /**
     * @param array $enabledPlugins
     * @return \Kpacha\Travis\QaTools\Config\Configuration
     */
    public function setEnabledPlugins($enabledPlugins)
    {
        $this->enabledPlugins = $enabledPlugins;
        return $this;
    }

}
