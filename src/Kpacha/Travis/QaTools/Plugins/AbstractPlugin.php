<?php

namespace Kpacha\Travis\QaTools\Plugins;

use Kpacha\Travis\QaTools\Config\Configuration;
use Satooshi\Component\File\Path;
use \Exception;
use \RuntimeException;

abstract class AbstractPlugin
{

    protected $name;

    /**
     * @var Configuration
     */
    protected $config;

    public function __construct(Configuration $config, $name = 'UNKNOWN')
    {
        $this->name = $name;
        $this->config = $config;
    }

    public function execute()
    {
        $command = $this->getShellCommand();
        if($options = $this->getArguments()) {
            $command .= ' ' . trim($options);
        }

        $output = $executionResult = null;
        exec($command, $output, $executionResult);

        return $this->checkResults($executionResult, $output);
    }

    protected abstract function getArguments();

    protected function checkResults($executionResult, $output)
    {
        if ($executionResult) {
            $serializedOutput = print_r($output, 1);
            throw new Exception("The execution of the plugin [{$this->name}] fails! $serializedOutput");
        }
        return $output;
    }

    protected function getShellCommand()
    {
        $command = realpath($this->config->getBinDir() . '/' . $this->name);
        $file = new Path();

        if (!$file->isRealFileReadable($command)) {
            throw new RuntimeException("The command $command was not found!");
        }

        return $command;
    }

    public function getName()
    {
        return $this->name;
    }

}

