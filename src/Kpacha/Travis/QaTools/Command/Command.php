<?php

namespace Kpacha\Travis\QaTools\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Kpacha\Travis\QaTools\Plugins\AbstractPlugin;
use Kpacha\Travis\QaTools\Config\Configurator;
use Kpacha\Travis\QaTools\Config\Configuration;
use \Exception;

class Command extends BaseCommand
{

    /**
     * Path to project root directory.
     *
     * @var string
     */
    private $rootDir;

    /**
     * Calls the default constructor and set up the root dir
     *
     * @param string $rootDir
     * @param string $name
     */
    public function __construct($rootDir, $name = null)
    {
        $this->rootDir = $rootDir;
        parent::__construct($name);
    }

    /**
     * Set up the command name, the expected arguments and the accepted options.
     */
    protected function configure()
    {
        $this
                ->setName('phpqa:test')
                ->setDescription('Launches a set of php qa tools (in a travis-ci environment)')
                ->addOption(
                        'config', null, InputOption::VALUE_OPTIONAL, '.phpqa.yml path', '.phpqa.yml'
                )
        ;
    }

    /**
     * Set up the compiler and require some services to the container in order to
     * write down the enhaced classes
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("");
        $output->writeln("Welcome to the <comment>travis-phpqa</comment> console command!");
        $output->writeln("");

        $configuration = $this->loadConfiguration($input);
        foreach ($this->getPlugins($configuration) as $plugin) {
            $this->executePlugin($plugin, $input, $output);
        }

        $output->writeln("");
        $output->writeln("<info>The work is done!</info>");
        $output->writeln("Have a nice day");
        $output->writeln("");
    }

    /**
     * Load configuration.
     * 
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @return \Kpacha\Travis\QaTools\Config\Configuration
     */
    protected function loadConfiguration(InputInterface $input)
    {
        $ymlPath = $this->rootDir . DIRECTORY_SEPARATOR . $input->getOption('config');

        $configurator = new Configurator;
        return $configurator->load($ymlPath, $this->rootDir);
    }

    protected function getPlugins(Configuration $config)
    {
        $plugins = array();
        foreach ($config->getEnabledPlugins() as $pluginName) {
            $pluginClass = $this->getPluginClassName($pluginName);
            $plugins[] = new $pluginClass($config, $pluginName);
        }
        return $plugins;
    }

    protected function getPluginClassName($pluginName)
    {
        return '\\Kpacha\\Travis\\QaTools\\Plugins\\' . $this->sanitizePluginName($pluginName) . 'Plugin';
    }

    protected function sanitizePluginName($pluginName)
    {
        $pluginName = ucfirst($pluginName);
        $func = create_function('$c', 'return strtoupper($c[1]);');
        return preg_replace_callback('/-([a-z])/', $func, $pluginName);
    }

    /**
     * Executes the plugin and catch the possible execution error
     *
     * @param \Kpacha\Travis\QaTools\Plugins\AbstractPlugin $plugin
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @throws Exception
     */
    protected function executePlugin(AbstractPlugin $plugin, InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Triggering the plugin <comment>{$plugin->getName()}</comment>. Please wait...");

        try {
            $result = $plugin->execute();
            $output->writeln("<info>OK</info>");
            if ($input->getOption('verbose')) {
                foreach ((array) $result as $resultLine) {
                    $output->writeln($resultLine);
                }
            }
        } catch (Exception $e) {
            throw new Exception("Triggering the plugin {$plugin->getName()}", null, $e);
        }
    }

}
