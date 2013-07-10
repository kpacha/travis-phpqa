<?php

namespace Kpacha\Travis\QaTools\Plugins;

class PhpcsPlugin extends AbstractPlugin
{

    protected function getArguments()
    {
        $logArguments = $this->getLogArguments();
        $configArguments = $this->getConfigArguments();
        $srcDir = $this->config->getSrcDir();
        return "$configArguments $logArguments $srcDir";
    }

    private function getLogArguments()
    {
        $logDir = $this->config->getLogDir();
        $arguments = array(
            '--report=xml',
            "--report-checkstyle=$logDir/checkstyle_checkstyle.xml",
            "--report-xml=$logDir/checkstyle.xml",
            "--report-full=$logDir/checkstyle_full.log",
            "--report-gitblame=$logDir/checkstyle_gitblame.log",
            "--report-source=$logDir/checkstyle_source.log"
        );
        return implode(' ', $arguments);
    }

    private function getConfigArguments()
    {
        return "--standard=PSR1,PSR2";
    }

    protected function checkResults($executionResult, $output)
    {
//        if ($executionResult) {
//            $serializedOutput = print_r($output, 1);
//            throw new Exception("The execution of the plugin [{$this->name}] fails! $serializedOutput");
//        }
        return $output;
    }

}
