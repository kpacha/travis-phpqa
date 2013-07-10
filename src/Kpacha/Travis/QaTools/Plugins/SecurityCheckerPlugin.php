<?php

namespace Kpacha\Travis\QaTools\Plugins;

class SecurityCheckerPlugin extends AbstractPlugin
{

    protected function getArguments()
    {
        $root = $this->config->getRootDir();
        return "security:check $root/composer.lock";
    }

}
