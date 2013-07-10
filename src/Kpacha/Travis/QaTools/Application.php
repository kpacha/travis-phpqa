<?php

namespace Kpacha\Travis\QaTools;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;

class Application extends BaseApplication
{

    /**
     * Path to project root directory.
     *
     * @var string
     */
    private $rootDir;

    /**
     * Constructor.
     *
     * @param string $rootDir Path to project root directory.
     * @param string $name    The name of the application
     * @param string $version The version of the application
     */
    public function __construct($rootDir, $name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        $this->rootDir = $rootDir;

        parent::__construct($name, $version);
    }

    /**
     * Gets the default commands that should always be available.
     *
     * @return Command[] An array of default Command instances
     */
    protected function getDefaultCommands()
    {
        return array(new Command\Command($this->rootDir));
    }
    
    /**
     * {@inheritdoc}
     *
     * @see \Symfony\Component\Console\Application::getCommandName()
     */
    protected function getCommandName(InputInterface $input)
    {
        return 'phpqa:test';
    }

    /**
     * {@inheritdoc}
     *
     * @see \Symfony\Component\Console\Application::getDefinition()
     */
    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        // clear out the normal first argument, which is the command name
        $inputDefinition->setArguments();

        return $inputDefinition;
    }
}