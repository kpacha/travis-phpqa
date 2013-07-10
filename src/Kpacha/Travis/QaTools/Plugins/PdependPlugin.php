<?php

namespace Kpacha\Travis\QaTools\Plugins;

class PdependPlugin extends AbstractPlugin
{

    protected function getArguments()
    {
        $logArguments = $this->getLogArguments();
        $srcDir = $this->config->getSrcDir();
        return "$logArguments $srcDir";
    }

    private function getLogArguments()
    {
        $logDir = $this->config->getLogDir();
        $arguments = array(
            "--jdepend-xml=$logDir/jdepend.xml",
            "--jdepend-chart=$logDir/dependencies.svg",
            "--overview-pyramid=$logDir/overview-pyramid.svg"
        );
        return implode(' ', $arguments);
    }

}
