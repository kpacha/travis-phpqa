<?php

namespace Kpacha\Travis\QaTools\Plugins;

class PhpunitPlugin extends AbstractPlugin
{

    protected function getArguments()
    {
        $logArguments = $this->getLogArguments();
        $testDir = $this->config->getTestDir();
        $configArguments = $this->getConfigArguments();
        return "$logArguments $configArguments $testDir";
    }

    private function getLogArguments()
    {
        $logDir = $this->config->getLogDir();
        return "--coverage-clover $logDir/coverage.xml --log-junit $logDir/junit.xml";
    }

    private function getConfigArguments()
    {
        $root = $this->config->getRootDir();
        return "-c $root/phpunit.xml.dist";
    }

}
