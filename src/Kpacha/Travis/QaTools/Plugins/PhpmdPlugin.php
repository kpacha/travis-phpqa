<?php

namespace Kpacha\Travis\QaTools\Plugins;

class PhpmdPlugin extends AbstractPlugin
{

    protected function getArguments()
    {
        $logArguments = $this->getLogArguments();
        $srcDir = $this->config->getSrcDir();
        return "$srcDir xml codesize $logArguments";
    }

    private function getLogArguments()
    {
        $logDir = $this->config->getLogDir();
        return "--reportfile $logDir/phpmd.xml";
    }

}
